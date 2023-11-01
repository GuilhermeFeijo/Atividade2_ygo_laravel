<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domains extends Model
{
    use HasFactory;

    protected $table = 'domains';

    protected $fillable = ['name', 'domain', 'status', 'created_by', 'created_at'];
}
