<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodolistModel extends Model
{
    use HasFactory;

    protected $table = 'todolist_models';

    protected $fillable = [
        'user_id',
        'task',
        'description',
        'status',
        'deadline',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}