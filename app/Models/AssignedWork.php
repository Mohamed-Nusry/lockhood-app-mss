<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AssignedWork extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'assignedworks';

    protected $fillable = [
        'name',
        'tasks',
        'status',
        'department_id',
        'employee_id',
        'kanban_id',
        'created_by',
        'updated_by',
    ];

    public function department() {
        return $this->belongsTo('App\Models\Department', 'department_id', 'id');
    }

    public function employee() {
        return $this->belongsTo('App\Models\User', 'employee_id', 'id');
    }

    public function kanban() {
        return $this->belongsTo('App\Models\Kanban', 'kanban_id', 'id');
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
