<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Kanban extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'tasks',
        'status',
        'department_id',
        'created_by',
        'updated_by',
    ];

    public function department() {
        return $this->belongsTo('App\Models\Department', 'department_id', 'id');
    }

    public function createdUser() {
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }

    public function updateUser() {
        return $this->belongsTo('App\Models\User', 'updated_by', 'id');
    }

}
