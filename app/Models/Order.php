<?php

// app/Models/Order.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_name',
        'order_value',
        'order_date',
        'order_status',
        'process_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'order_date' => 'datetime',
    ];

    /**
     * Generate a random process ID.
     *
     * @return int
     */
    public static function generateProcessId()
    {
        return rand(1, 10);
    }
}
