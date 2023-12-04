<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'date', 'sum', 'comment', 'name'];
    protected $hidden = ['created_at', 'updated_at'];
}
