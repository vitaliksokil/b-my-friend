<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    protected $fillable = [
        'img',
        'user_id','description'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }


    public function getImgAttribute($value){
        return '/uploads/user/'.auth()->user()->id.'/'. $value;
    }
}
