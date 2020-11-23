<?php

namespace App\Http\Controllers\Api;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{


    private function checkIfCurrentUserIsAnOwner(Post $post){
        return auth()->user()->id == $post->user_id ? true : false;
    }


    /**
     * @OA\Get(
     * path="/api/users/posts?page={page}",
     * summary="Get all users posts",
     * description="
    There are fields:
    -current_page - current page that requested;
    - data - array with users
    - first_page_url - url that should be requested to get data of first page
    - from - from which record we get next part of data
    - to  - to which record we will fetch data ( for example from:1, to: 20 - this is 1 page)
    - per_page - number of records per page ( always will be 20)
    - last_page_url - page that was called before ( this is not previous page)
    - next_page_url - url for next page
    - prev_page_url - url for previous page
    - total - total count of all records
     ",
     * operationId="getUsersPosts",
     * tags={"users/posts"},
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
                    "title":"test",
                    "body": "Post body",
                    "created_at": "2020-11-23 19:54:26",
                    "updated_at": "2020-11-23 19:54:26",
                    },
                    {
                    "id": 2,
                    "user_id": 1,
                    "title":"test 2 ",
                    "body": "Post body 2",
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
    public function index()
    {
        return response()->json(auth()->user()->posts()->paginate(20),200);
    }


    /**
     * @OA\Post(
     * path="/api/users/posts",
     * summary="Create new post",
     * description="",
     * operationId="postUsersPosts",
     * tags={"users/posts"},
     * security={ {"bearer": {}} },
     *
     *  @OA\RequestBody(
     *    required=true,
     *    description="Pass post data",
     *    @OA\JsonContent(
     *       required={"title", "body"},
     *       @OA\Property(property="title", type="string", format="text", example="Title 1"),
     *       @OA\Property(property="body", type="string", format="text", example="Body 1"),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(property="success", type="string", example="Post successfully added")
     *        )
     *     ),
     *@OA\Response(
     *    response=500,
     *    description="Error",
     *     @OA\JsonContent(
     *       @OA\Property(property="error", type="object", example="Something went wrong!")
     *        )
     *     ),
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'body' => 'required',
        ]);
        if ($validator->fails()) {
            return new Response($validator->errors(), 400);
        }
        if(Post::create(array_merge($request->all(),['user_id'=>auth()->user()->id]))){
            return new Response(['success'=>'Post successfully added'], 200);
        }else{
            return new Response(['error'=>'Something went wrong!'], 500);
        }
    }


    /**
     * @OA\Get(
     * path="/api/users/posts/{id}",
     * summary="Get one post",
     * description="",
     * operationId="getUsersPost",
     * tags={"users/posts"},
     * security={ {"bearer": {}} },
     * @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Post id",
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
     *       @OA\Property(property="post", type="object", example={
    {
          "id":3,
          "user_id":2,
          "title":"3333",
          "body":"33333",
          "created_at":"2020-11-23 19:54:26",
          "updated_at":"2020-11-23 19:54:26"
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
    public function show(Post $post)
    {
        return response()->json(['post'=>$post],200);
    }

    /**
     * @OA\Put(
     * path="/api/users/posts/{id}",
     * summary="Update post",
     * description="",
     * operationId="putUsersPosts",
     * tags={"users/posts"},
     * security={ {"bearer": {}} },
     * @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Post id",
     *          example=1,
     *        @OA\Schema(
     *           type="integer",
     *           format="int64"
     *      )
     * ),
     *  @OA\RequestBody(
     *
     *    required=true,
     *    description="Pass post data",
     *    @OA\JsonContent(
     *       required={"title", "body"},
     *       @OA\Property(property="title", type="string", format="text", example="Title 1"),
     *       @OA\Property(property="body", type="string", format="text", example="Body 1"),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(property="success", type="string", example="Successfully updated")
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
     *   @OA\Response(
     *    response=404,
     *    description="Error",
     *     @OA\JsonContent(
     *       @OA\Property(property="error", type="object", example="Not found")
     *        )
     *     ),
     * )
     */
    public function update(Request $request, Post $post)
    {
        if($this->checkIfCurrentUserIsAnOwner($post)){
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'body' => 'required',
            ]);
            if ($validator->fails()) {
                return new Response($validator->errors(), 400);
            }
            $post->update($request->all());
            return new Response(['success'=>'Successfully updated'], 200);
        }else{
            return new Response(['error'=>'Forbidden'], 403);
        }
    }



    /**
     * @OA\Delete(
     * path="/api/users/posts/{id}",
     * summary="Delete post",
     * description="",
     * operationId="deleteUsersPosts",
     * tags={"users/posts"},
     * security={ {"bearer": {}} },
     * @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Post id",
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
    public function destroy(Post $post)
    {
        if($this->checkIfCurrentUserIsAnOwner($post)){
            if($post->delete()){
                return new Response(['success'=>'Successfully deleted'], 200);
            }
        }else{
            return new Response(['error'=>'Forbidden'], 403);
        }
    }
}
