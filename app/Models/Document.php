<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable=[
        'employee_id',
        'docname',
        'docpath'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
