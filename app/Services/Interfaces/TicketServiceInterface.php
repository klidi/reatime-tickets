<?php
/**
 * Created by IntelliJ IDEA.
 * User: iraklid
 * Date: 11.10.20
 * Time: 9:17 PM
 */

namespace App\Services\Interfaces;


use App\Models\Ticket;
use Illuminate\Database\Eloquent\Collection;

interface TicketServiceInterface
{
    public function createTicket(array $input) : ?Ticket;
    public function deleteTicket(Ticket $ticket) : void;
    public function getClearanceValues() : array;
    public function reserve(int $value) : ?array;
}
