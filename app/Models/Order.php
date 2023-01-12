<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Order extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_no',
        'product_id',
        'customer_name',
        'address',
        'mobile',
        'amount',
        'discount',
        'total',
        'payment_status',
        'reference',
        'status',
        'created_by',
        'updated_by',
    ];

    public function createdUser() {
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }

    public function updateUser() {
        return $this->belongsTo('App\Models\User', 'updated_by', 'id');
    }

}
