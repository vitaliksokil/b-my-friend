<?php

namespace App\Http\Controllers\Api;

use App\Follower;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FollowerController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/followers/get-all?page={page}",
     * summary="Get all followers",
     * description="Returns pagination object with all followers.
    There are fields: <br>
    -current_page - current page that requested; <br>
    - data - array with users <br>
    - first_page_url - url that should be requested to get data of first page (WARNING : this should be POST <br>
    request with get parameter 'page' !!!! ) <br>
    - from - from which record we get next part of data <br>
    - to  - to which record we will fetch data ( for example from:1, to: 20 - this is 1 page) <br>
    - per_page - number of records per page ( always will be 20) <br>
    - last_page_url - page that was called before ( this is not previous page) <br>
    - next_page_url - url for next page ( WARNING: this should be POST request with get parameter 'page'!!!) <br>
    - prev_page_url - url for previous page (WARNING: this should be POST request with get parameter 'page'!!!) <br>
    - total - total count of all records <br>
    ",
     * operationId="followersGetAll",
     * tags={"followers"},
     *      security={ {"bearer": {}} },
     * @OA\Parameter(
     *          name="page",
     *          in="path",
     *          description="Number of page",
     *          example=1,
     *        @OA\Schema(
     *           type="integer",
     *           format="int64"
     *      )
     * ),
    @OA\Response(
     *    response=200,
     *    description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(property="current_page", type="integer", example=1),
     *       @OA\Property(property="data", type="object", example={
     *     {
    "id":2,
    "name": "Name",
    "email": "test@gmail.com",
    "email_verified_at": "2020-11-11 22:04:31",
    "email_verification_token": null
     *     }
     *     }),
     *      @OA\Property(property="first_page_url", type="string", example="http://b-my-friend.loc/api/followers/get-all?page=1"),
     *      @OA\Property(property="from", type="integer", example=1),
     *      @OA\Property(property="last_page", type="integer", example=2),
     *      @OA\Property(property="last_page_url", type="string", example="http://b-my-friend.loc/api/followers/get-all?page=2"),
     *      @OA\Property(property="next_page_url", type="string", example="http://b-my-friend.loc/api/followers/get-all?page=2"),
     *      @OA\Property(property="path", type="string", example="http://b-my-friend.loc/api/followers/get-all"),
     *      @OA\Property(property="per_page", type="integer", example=20),
     *      @OA\Property(property="prev_page_url", type="string", example="http://b-my-friend.loc/api/followers/get-all?page=2"),
     *      @OA\Property(property="to", type="integer", example=20),
     *      @OA\Property(property="total", type="integer", example=22),
     *        )
     *     ),
     *
     *
     * )
     */
    public function getAllFollowers(){
        return auth()->user()->followers()->paginate(20);
    }

    /**
     * @OA\Get(
     * path="/api/followers/count-all",
     * summary="Get count of followers",
     * description="Returns count of user's followers",
     * operationId="followersGetCountAll",
     * tags={"followers"},
     * security={ {"bearer": {}} },
        @OA\Response(
     *    response=200,
     *    description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(property="count", type="integer", example=1),
     *
     *        )
     *     ),
     *
     *
     * )
     */
    public function getAllFollowersCount(){
        return new Response(['count' => count(auth()->user()->followers)] , 200);
    }

    /**
     * @OA\Get(
     * path="/api/following/get-all?page={page}",
     * summary="Get all following",
     * description="Returns pagination object with all following.
    There are fields: <br>
    -current_page - current page that requested; <br>
    - data - array with users <br>
    - first_page_url - url that should be requested to get data of first page (WARNING : this should be POST <br>
    request with get parameter 'page' !!!! ) <br>
    - from - from which record we get next part of data <br>
    - to  - to which record we will fetch data ( for example from:1, to: 20 - this is 1 page) <br>
    - per_page - number of records per page ( always will be 20) <br>
    - last_page_url - page that was called before ( this is not previous page) <br>
    - next_page_url - url for next page ( WARNING: this should be POST request with get parameter 'page'!!!) <br>
    - prev_page_url - url for previous page (WARNING: this should be POST request with get parameter 'page'!!!) <br>
    - total - total count of all records <br>
    ",
     * operationId="followingGetAll",
     * tags={"following"},
     *      security={ {"bearer": {}} },
     * @OA\Parameter(
     *          name="page",
     *          in="path",
     *          description="Number of page",
     *          example=1,
     *        @OA\Schema(
     *           type="integer",
     *           format="int64"
     *      )
     * ),
    @OA\Response(
     *    response=200,
     *    description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(property="current_page", type="integer", example=1),
     *       @OA\Property(property="data", type="object", example={
     *     {
    "id":2,
    "name": "Name",
    "email": "test@gmail.com",
    "email_verified_at": "2020-11-11 22:04:31",
    "email_verification_token": null
     *     }
     *     }),
     *      @OA\Property(property="first_page_url", type="string", example="http://b-my-friend.loc/api/following/get-all?page=1"),
     *      @OA\Property(property="from", type="integer", example=1),
     *      @OA\Property(property="last_page", type="integer", example=2),
     *      @OA\Property(property="last_page_url", type="string", example="http://b-my-friend.loc/api/following/get-all?page=2"),
     *      @OA\Property(property="next_page_url", type="string", example="http://b-my-friend.loc/api/following/get-all?page=2"),
     *      @OA\Property(property="path", type="string", example="http://b-my-friend.loc/api/following/get-all"),
     *      @OA\Property(property="per_page", type="integer", example=20),
     *      @OA\Property(property="prev_page_url", type="string", example="http://b-my-friend.loc/api/following/get-all?page=2"),
     *      @OA\Property(property="to", type="integer", example=20),
     *      @OA\Property(property="total", type="integer", example=22),
     *        )
     *     ),
     *
     *
     * )
     */
    public function getAllFollowing(){
        return auth()->user()->following()->paginate(20);
    }

    /**
     * @OA\Get(
     * path="/api/following/count-all",
     * summary="Get count of following",
     * description="Returns count of user's following",
     * operationId="followingGetCountAll",
     * tags={"following"},
     * security={ {"bearer": {}} },
    @OA\Response(
     *    response=200,
     *    description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(property="count", type="integer", example=1),
     *
     *        )
     *     ),
     *
     *
     * )
     */
    public function getAllFollowingCount(){
        return new Response(['count' => count(auth()->user()->following)] , 200);
    }


    /**
     * @OA\Post(
     * path="/api/following/follow",
     * summary="Follow to some user",
     * description="Follow to some user",
     * operationId="followingFollow",
     * tags={"following"},
     * security={ {"bearer": {}} },
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user id",
     *    @OA\JsonContent(
     *        @OA\Property(property="user_id", type="integer",  example=1),
     *    ),
     * ),
    @OA\Response(
     *    response=200,
     *    description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(property="success", type="string", example="Successfully followed Name"),
     *
     *        )
     *     ),
     *
     * @OA\Response(
     *    response=400,
     *    description="Error",
     *     @OA\JsonContent(
     *       @OA\Property(property="error", type="string", example="Incorrect user id"),
     *
     *        )
     *     ),
     *
     * )
     */
    public function follow(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer'
        ]);
        if ($validator->fails()) {
            return new Response($validator->errors(), 400);
        }
        $follower = auth()->user();
        $following = User::find($request->user_id);
        if($following instanceof User){
            try {
                $newFollower =  new Follower();
                $newFollower->follower_id = $follower->id;
                $newFollower->following_id = $following->id;
                $newFollower->save();
                return new Response(['success' => 'Successfully followed ' . $following->name], 200);
            }catch (\Exception $exception){
                return new Response(['error' => 'Something went wrong! Maybe you have already following current user'], 400);
            }
        }else{
            return new Response(['error' => 'Incorrect user id'], 400);
        }
    }

    /**
     * @OA\Post(
     * path="/api/following/unfollow",
     * summary="Unfollow from one user",
     * description="Unfollow from one user",
     * operationId="followingUnfollow",
     * tags={"following"},
     * security={ {"bearer": {}} },
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user id",
     *    @OA\JsonContent(
     *        @OA\Property(property="user_id", type="integer",  example=1),
     *    ),
     * ),
    @OA\Response(
     *    response=200,
     *    description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(property="success", type="string", example="Successfully unfollowed"),
     *
     *        )
     *     ),
     *
     * @OA\Response(
     *    response=500,
     *    description="Error",
     *     @OA\JsonContent(
     *       @OA\Property(property="error", type="string", example="Something went wrong!!!"),
     *
     *        )
     *     ),
     **
     * @OA\Response(
     *    response=400,
     *    description="Error",
     *     @OA\JsonContent(
     *       @OA\Property(property="error", type="string", example="Incorrect user id"),
     *
     *        )
     *     ),
     *
     * )
     */
    public function unFollow(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer'
        ]);
        if ($validator->fails()) {
            return new Response($validator->errors(), 400);
        }
        $follower = auth()->user();
        $following = User::find($request->user_id);

        $followerRow = Follower::where([
            ['follower_id',$follower->id],
            ['following_id',$following->id]
        ])->first();
        if($followerRow instanceof Follower){
            if($followerRow->delete()){
                return new Response(['success' => 'Successfully unfollowed'], 200);
            }else{
                return new Response(['error' => 'Something went wrong!!!'], 500);
            }
        }else{
            return new Response(['error' => 'Incorrect user id'], 400);
        }
    }
}
