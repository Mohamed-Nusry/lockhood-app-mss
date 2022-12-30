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

}
