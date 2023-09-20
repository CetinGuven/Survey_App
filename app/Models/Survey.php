<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Survey extends Model
{
    protected $table = "surveys";
    use HasFactory;

    protected $fillable = [
        'user_id',
        'question',
        'answer1',
        'answer2',
        'answer3',
        'answer4',
        'answer5',
    ];
}