<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chatbot_database extends Model
{
    use HasFactory;

    protected $table = 'chatbot_database';
    
    protected $fillable = [
        'keyword',
        'expression',
        'response',
    ];
}
