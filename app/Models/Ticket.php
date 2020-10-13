<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Ticket
 * @package App\Models
 * @version October 10, 2020, 4:05 pm UTC
 *
 * @property string $name
 * @property integer $value
 */
class Ticket extends Model
{
    public $table = 'tickets';

    protected $dates = ['created_at', 'updated_at'];

    public $fillable = [
        'name',
        'value',
        'price'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'value' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|min:3|max:20',
        'value' => 'required|numeric|gt:0',
        'price' => 'required|numeric|gt:0'
    ];

}
