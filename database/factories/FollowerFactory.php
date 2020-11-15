<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Follower;
use App\Model;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

$factory->define(Follower::class, function (Faker $faker) {
    $arrayOfUsersIds = DB::table('users')->select('id')->get()->map(function ($item){
        return $item->id;
    })->toArray();
    do{
        $follower = $arrayOfUsersIds[array_rand($arrayOfUsersIds)];
        $following = $arrayOfUsersIds[array_rand($arrayOfUsersIds)];
    }while($follower === $following);
    return [
        'follower_id' => $follower,
        'following_id' => $following
    ];
});
