<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class OrderProduct extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'product_id',
    ];

    public function product() {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }

    public function order() {
        return $this->belongsTo('App\Models\Order', 'order_id', 'id');
    }

}
