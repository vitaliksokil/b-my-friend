<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{

    public function follower(){
        return $this->belongsTo(User::class);
    }
    public function following(){
        return $this->belongsTo(User::class);
    }
}
