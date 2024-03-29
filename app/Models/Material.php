<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Material extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
        'supplier_id',
        'qty',
        'purchase_price',
        'created_by',
        'updated_by',
    ];

    public function supplier() {
        return $this->belongsTo('App\Models\Supplier', 'supplier_id', 'id');
    }

    public function user() {
        return $this->belongsTo('App\Models\User', 'updated_by', 'id');
    }

    public function createdUser() {
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }

    public function updateUser() {
        return $this->belongsTo('App\Models\User', 'updated_by', 'id');
    }


}
