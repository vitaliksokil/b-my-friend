<?php

namespace App\Http\Controllers\Api;

use App\Feed;
use App\Http\Controllers\Controller;

use App\Services\FileUploaderService\FileUploaderServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class FeedController extends Controller
{

    /**
     * @OA\Post(
     * path="/api/users/feeds",
     * summary="Create new feed",
     * description="Img should be in base 64",
     * operationId="postUsersFeeds",
     * tags={"users/feeds"},
     * security={ {"bearer": {}} },
     *
     *  @OA\RequestBody(
     *    required=true,
     *    description="Pass feed data",
     *     @OA\JsonContent(
     *       required={"description","img"},
     *       @OA\Property(property="description", type="string", format="text", example="Body 1"),
     *       @OA\Property(property="img", type="string", format="text", example="base 64 "),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(property="success", type="string", example="Feed successfully created")
     *        )
     *     ),
     * @OA\Response(
     *    response=400,
     *    description="Error",
     *    @OA\JsonContent(
     *       @OA\Property(property="title", type="object", example={
                "The img field is required."
                })
     *     )
     * ),
     * @OA\Response(
     *    response=500,
     *    description="Error",
     *     @OA\JsonContent(
     *       @OA\Property(property="error", type="object", example="Something went wrong!")
     *        )
     *     ),
     * )
     */
    public function store(Request $request,FileUploaderServiceInterface $fileUploaderService){
        $validator = Validator::make($request->all(), [
            'img' => 'required',
            'description' => 'required'
        ]);
        if ($validator->fails()) {
            return new Response($validator->errors(), 400);
        }
//        $fileName = $fileUploaderService->uploadFile('uploads/user/'.auth()->user()->id,$request->img);
        if(Feed::create(['user_id'=>auth()->user()->id,'img'=>$request->img,'description'=>$request->description])){
            return new Response(['success'=>'Feed successfully added'], 200);
        }else{
            return new Response(['error'=>'Something went wrong!'], 500);
        }
    }

    /**
     * @OA\Get(
     * path="/api/users/feeds?page={page}",
     * summary="Get all users feeds",
     * description="
    There are fields:
    -current_page - current page that requested;
    - data - array with user feeds
    - first_page_url - url that should be requested to get data of first page
    - from - from which record we get next part of data
    - to  - to which record we will fetch data ( for example from:1, to: 20 - this is 1 page)
    - per_page - number of records per page ( always will be 20)
    - last_page_url - page that was called before ( this is not previous page)
    - next_page_url - url for next page
    - prev_page_url - url for previous page
    - total - total count of all records
    ",
     * operationId="getUsersFeeds",
     * tags={"users/feeds"},
     * security={ {"bearer": {}} },
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
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(property="current_page", type="integer", example=1),
     *       @OA\Property(property="data", type="object", example={
    {
    "id": 1,
    "user_id": 1,
    "img": "base64",
    "description": "dasdasd1444",
    "created_at": "2020-11-23 19:54:26",
    "updated_at": "2020-11-23 19:54:26",
    },
    {
    "id": 2,
    "user_id": 1,
    "img": "base64",
    "description": "dasdasd1444",
    "created_at": "2020-11-23 19:54:26",
    "updated_at": "2020-11-23 19:54:26",
    },

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
     * )
     */
    public function index(){
        $user = auth()->user();
        $feeds = Feed::where('user_id', $user->id)->paginate(20);
        return response()->json(['feeds'=>$feeds->toArray()],200);
    }

    /**
     * @OA\Get(
     * path="/api/users/feeds/{id}",
     * summary="Get one feed",
     * description="",
     * operationId="getUsersFeed",
     * tags={"users/feeds"},
     * security={ {"bearer": {}} },
     * @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Feed id",
     *          example=1,
     *        @OA\Schema(
     *           type="integer",
     *           format="int64"
     *      )
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(property="feed", type="object", example={
    {
    "id": 1,
    "user_id": 1,
    "img": "/uploads/user/1/1606481359.jpg",
    "description": "dasdasd1444",
    "created_at": "2020-11-23 19:54:26",
    "updated_at": "2020-11-23 19:54:26",
    }
    })
     *        )
     *     ),
     *   @OA\Response(
     *    response=404,
     *    description="Error",
     *     @OA\JsonContent(
     *       @OA\Property(property="error", type="object", example="Not found")
     *        )
     *     ),
     * )
     */
    public function show(Feed $feed){
        return response()->json(['feed'=>$feed],200);
    }



    /**
     * @OA\Put(
     * path="/api/users/feeds/{id}",
     * summary="Update feed",
     * description="",
     * operationId="putUsersFeeds",
     * tags={"users/feeds"},
     * security={ {"bearer": {}} },
     * @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Feed id",
     *          example=1,
     *        @OA\Schema(
     *           type="integer",
     *           format="int64"
     *      )
     * ),
     *  @OA\RequestBody(
     *
     *    required=true,
     *    description="Pass feed data",
     *    @OA\JsonContent(
     *       required={"description"},
     *       @OA\Property(property="description", type="string", format="text", example="Body 1"),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(property="success", type="string", example="Successfully updated")
     *        )
     *     ),
     *
     * @OA\Response(
     *    response=400,
     *    description="Error",
     *    @OA\JsonContent(
     *       @OA\Property(property="description", type="object", example={
    "The description field is required."
    })
     *     )
     * ),
     *@OA\Response(
     *    response=403,
     *    description="Error",
     *     @OA\JsonContent(
     *       @OA\Property(property="error", type="object", example="Forbidden")
     *        )
     *     ),
     *
     *   @OA\Response(
     *    response=404,
     *    description="Error",
     *     @OA\JsonContent(
     *       @OA\Property(property="error", type="object", example="Not found")
     *        )
     *     ),
     * )
     */
    public function update(Request $request, Feed $feed){
        $validator = Validator::make($request->all(), [
            'description' => 'required'
        ]);
        if ($validator->fails()) {
            return new Response($validator->errors(), 400);
        }
        $user = auth()->user();
        if($user->id == $feed->user_id){
            $feed->update($request->all());
            return new Response(['success'=>'Feed successfully updated'], 200);
        }else{
            return new Response(['error'=>'This action is unauthorized'], 403);
        }

    }


    /**
     * @OA\Delete(
     * path="/api/users/feeds/{id}",
     * summary="Delete feed",
     * description="",
     * operationId="deleteUsersFeed",
     * tags={"users/feeds"},
     * security={ {"bearer": {}} },
     * @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Feed id",
     *          example=1,
     *        @OA\Schema(
     *           type="integer",
     *           format="int64"
     *      )
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(property="success", type="string", example="Successfully deleted")
     *        )
     *     ),
     *@OA\Response(
     *    response=403,
     *    description="Error",
     *     @OA\JsonContent(
     *       @OA\Property(property="error", type="object", example="Forbidden")
     *        )
     *     ),
     *
     *     @OA\Response(
     *    response=404,
     *    description="Error",
     *     @OA\JsonContent(
     *       @OA\Property(property="error", type="object", example="Not found")
     *        )
     *     ),
     * )
     */
    public function destroy(Feed $feed){
        $user = auth()->user();
        if($user->id == $feed->user_id){
            if(file_exists(public_path().$feed->img)){
                unlink(public_path().$feed->img);
            }
            $feed->delete();
            return new Response(['success'=>'Feed successfully deleted'], 200);
        }else{
            return new Response(['error'=>'This action is unauthorized'], 403);
        }
    }
}
