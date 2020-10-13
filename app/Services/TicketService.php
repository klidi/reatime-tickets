<?php
/**
 * Created by IntelliJ IDEA.
 * User: iraklid
 * Date: 11.10.20
 * Time: 9:17 PM
 */

namespace App\Services;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Redis;
use SwooleTW\Http\Websocket\Facades\Websocket;
use App\Services\Interfaces\TicketServiceInterface;

class TicketService implements TicketServiceInterface
{
    const CLEARANCES_REDIS_KEY = 'ticket:clearances';
    const STATUS_RESERVED = 'reserved';

    /**
     * @param array $input
     * @return Ticket|null
     */
    public function createTicket(array $input) : ?Ticket
    {
        $ticket = Ticket::create($input);
        if ($ticket->id) {
            $this->appendTicketClearanceCombo($ticket);
        }
        return $ticket ?: null;
    }

    /**
     * @param Ticket $ticket
     */
    public function deleteTicket(Ticket $ticket) : void
    {
        $ticket->delete();
        if ($ticket->status !== self::STATUS_RESERVED) {
            $clearances = $this->regenClearances();
            $encodedClearances = json_encode($clearances);

            Websocket::broadcast()->emit('levelChanges', array_keys($clearances));
            Redis::set(self::CLEARANCES_REDIS_KEY, $encodedClearances);
        }
    }

    /**
     * @param Ticket $ticket
     */
    private function appendTicketClearanceCombo(Ticket $ticket) : void
    {
        $clearances = $this->getClearances() ? $this->getClearances() : [];
        $this->combine($ticket, $clearances);
        // this will be emittet imediately before
        Websocket::broadcast()->emit('levelChanges', array_keys($clearances));
        Redis::set(self::CLEARANCES_REDIS_KEY, json_encode($clearances));
    }

    /**
     * @return array
     */
    public function getClearanceValues() : array
    {
        return array_keys($this->getClearances());
    }

    /**
     * @param int $value
     * @return Collection|null
     */
    public function reserve(int $value) : ?array
    {
        $ticketIds = isset($this->getClearances()[$value]) ? $this->getClearances()[$value] : [];
        if (count($ticketIds) > 0) {
            Ticket::whereIn('id', $ticketIds)->update(['status' => self::STATUS_RESERVED]);
            $clearances = $this->regenClearances();
            $clearances = array_keys($clearances);
            Websocket::emit('reservationCompleted', $clearances);
            Websocket::broadcast()->emit('levelChanges', $clearances);
        } else {
            Websocket::emit('reservationFailed', array_keys($this->regenClearances()));
        }
        return $ticketIds;
    }

    /**
     * @return array
     */
    private function getClearances() : array
    {
        return Redis::exists(self::CLEARANCES_REDIS_KEY)
            ? json_decode(Redis::get(self::CLEARANCES_REDIS_KEY), true) : $this->regenClearances();
    }

    /**
     * re-calculate Clearances
     */
    private function regenClearances() : array
    {
        $tickets = Ticket::select('id', 'value')->where('status', '=', 'available')->get();
        $clearances = [];

        for ($i = 0; $i < $tickets->count(); $i++) {
            $this->combine($tickets[$i], $clearances);
        }
        Redis::set(self::CLEARANCES_REDIS_KEY, json_encode($clearances));
        return $clearances;
    }

    /**
     * There is few different solutions to generating
     *
     * @param Ticket $ticket
     * @param array $clearances
     * @param $newClearances
     * @return array
     */
    private function combine(Ticket $ticket, array &$clearances) : void
    {
        foreach($clearances as $clearanceValue => $ticketCombo) {
            $ticketCombo[] = $ticket->id;
            if (!isset($clearances[$clearanceValue + $ticket->value])) {
                $clearances[$clearanceValue + $ticket->value] = $ticketCombo;
            }
        }
        if (!isset($clearances[$ticket->value])) {
            $clearances[$ticket->value] = [$ticket->id];
        }
    }
}
