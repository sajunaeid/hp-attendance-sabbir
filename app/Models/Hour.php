<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hour extends Model
{
    use HasFactory;


    protected $fillable = [
        'employee_id',
        'in_time',
        'out_time',
        'wh_time'
    ];
}
