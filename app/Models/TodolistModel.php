<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodolistModel extends Model
{
    use HasFactory;

    protected $table = "todolist_models";
    protected $fillable = ["task", "description", "status", "deadline"];
}
