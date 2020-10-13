<?php
/**
 * Created by IntelliJ IDEA.
 * User: iraklid
 * Date: 13.10.20
 * Time: 6:15 PM
 */

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AppBaseController;
use App\Services\Interfaces\TicketServiceInterface;

class ReservationController extends AppBaseController
{
    private $ticketService;

    public function __construct(TicketServiceInterface $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    public function index()
    {
        /** @var Reservation $reservations */
        $reservations = Reservation::all();

        return view('reservations.index')
            ->with('reservations', $reservations);
    }

    /**
     * @param $websocket
     * @param $data
     */
    public function store($websocket, $data)
    {
        $ticketIds = $this->ticketService->reserve($data);

        $reservation = Reservation::create(['clearance' => $data, 'user_id' => Auth::user()->id]);

        foreach ($ticketIds as $id) {
            $reservation->reservationTickets()->create([
                'ticket_id' => $id,
            ]);
        }
        return null;
    }
}
