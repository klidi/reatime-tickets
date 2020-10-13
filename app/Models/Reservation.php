<?php
/**
 * Created by IntelliJ IDEA.
 * User: iraklid
 * Date: 13.10.20
 * Time: 3:32 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reservation extends Model
{
    public $table = 'reservations';

    protected $dates = ['created_at', 'updated_at'];

    public $fillable = ['clearance', 'user_id'];

    public function reservationTickets() : HasMany
    {
        return $this->hasMany('App\Models\ReservationTicket');
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }
}
