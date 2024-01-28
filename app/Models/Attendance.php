<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;



    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'employee_id',
        'scan_type',
        'scan_time',
    ];


    protected $with = ['employee'];
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
        // local id is the main id Of post table such as : id
        // foreign id is the post table which is inside comment table such as: post_id
        // return $this->hasMany(Comment::class, 'post_id', 'id');
        // return $this->hasMany(Comment::class, 'post_id');
    }

}
