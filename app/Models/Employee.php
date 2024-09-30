<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'nid',
        'emp_id',
        'emp_number',
        'wh',
        'score',
        'score_note',
        'we',
        'pp'
    ];


    protected $with = ['hours'];
    public function hours()
    {
        return $this->hasMany(Hour::class, 'employee_id', 'id');
        // local id is the main id Of post table such as : id
        // foreign id is the post table which is inside comment table such as: post_id
        // return $this->hasMany(Comment::class, 'post_id', 'id');
        // return $this->hasMany(Comment::class, 'post_id');
    }


    public function documents(){
        return $this->hasMany(Document::class, 'employee_id','id');
    }


}
