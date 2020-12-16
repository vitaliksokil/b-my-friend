<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'owner_id',
        'title',
        'description'
    ];
    public function owner(){
        return $this->belongsTo(User::class,'owner_id');
    }
}
