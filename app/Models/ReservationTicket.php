<?php
/**
 * Created by IntelliJ IDEA.
 * User: iraklid
 * Date: 13.10.20
 * Time: 3:33 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReservationTicket extends Model
{
    public $timestamps = false;

    public $table = 'reservation_tickets';

    public $fillable = ['ticket_id'];

    public function ticket() : BelongsTo
    {
       return $this->belongsTo('App\Models\Ticket');
    }

    public function reservation() : BelongsTo
    {
        return $this->belongsTo('App\Models\Reservation');
    }
}
