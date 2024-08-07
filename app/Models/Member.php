<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    protected $fillable = ['group_id', 'user_id'];

    public function getGroup()
    {
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }



}
