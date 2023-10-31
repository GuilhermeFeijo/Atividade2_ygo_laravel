<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tickets extends Model
{
    use HasFactory;

    protected $table = 'tickets';

    protected $fillable = ['title', 'description', 'type', 'protocol', 'user_id', 'created_by', 'open_at', 'created_at'];
}
