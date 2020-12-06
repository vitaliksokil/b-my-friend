<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/users?page={page}",
     * summary="Get all users",
     * description="Returns pagination object with all users.
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
     * operationId="usersGetAll",
     * tags={"users"},
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
            "email_verification_token": null,
            "img": "base64",
     *     }
*     }),
     *      @OA\Property(property="first_page_url", type="string", example="http://b-my-friend.loc/api/users/get-all?page=1"),
     *      @OA\Property(property="from", type="integer", example=1),
     *      @OA\Property(property="last_page", type="integer", example=2),
     *      @OA\Property(property="last_page_url", type="string", example="http://b-my-friend.loc/api/users/get-all?page=2"),
     *      @OA\Property(property="next_page_url", type="string", example="http://b-my-friend.loc/api/users/get-all?page=2"),
     *      @OA\Property(property="path", type="string", example="http://b-my-friend.loc/api/users/get-all"),
     *      @OA\Property(property="per_page", type="integer", example=20),
     *      @OA\Property(property="prev_page_url", type="string", example="http://b-my-friend.loc/api/users/get-all?page=2"),
     *      @OA\Property(property="to", type="integer", example=20),
     *      @OA\Property(property="total", type="integer", example=22),
     *        )
     *     ),
     *
     *
     * )
     */
    public function getAllUsers(){
        return User::where('id', '!=', auth()->id())->paginate(20);
    }




    /**
     * @OA\Put(
     * path="/api/users",
     * summary="Update user's data",
     * description="",
     * operationId="putUsers",
     * tags={"users"},
     * security={ {"bearer": {}} },
     *  @OA\RequestBody(
     *    required=true,
     *    description="Pass user data",
     *    @OA\JsonContent(
     *       required={"name"},
     *       @OA\Property(property="name", type="string", format="text", example="name"),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(property="success", type="string", example="Successfully updated")
     *        )
     *     ),
     * @OA\Response(
     *    response=400,
     *    description="Error",
     *    @OA\JsonContent(
     *       @OA\Property(property="name", type="object", example={
            "The name field is required."
            })
     *     )
     * )
     * )
     */
    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return new Response($validator->errors(), 400);
        }
        $user = auth()->user();
        if($user->update($request->all())){
            return new Response(['success'=>'Successfully updated'], 200);
        }else{
            return new Response(['error'=>'Something went wrong'], 500);
        }
    }



    /**
     * @OA\Patch(
     * path="/api/users/upload-photo",
     * summary="Upload user photo",
     * description="",
     * operationId="uploadUserPhoto",
     * tags={"users"},
     * security={ {"bearer": {}} },
     *  @OA\RequestBody(
     *
     *    required=true,
     *    description="Pass image in base64",
     *    @OA\JsonContent(
     *       required={"img"},
     *       @OA\Property(property="img", type="string", format="text", example="base 64"),
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
     *    response=422,
     *    description="Error",
     *    @OA\JsonContent(
     *       @OA\Property(property="errors", type="object", example={
     "img":{"The img field is required."}
    })
     *     )
     * ),
     * )
     */
    public function uploadPhoto(Request $request){
        $validator = Validator::make($request->all(), [
            'img' => 'required',
        ]);
        if ($validator->fails()) {
            return new Response(['errors'=>$validator->errors()], 400);
        }
        if(auth()->user()->update(['img'=>$request->img])){
            return new Response(['success'=>'User image successfully added'], 200);
        }else{
            return new Response(['error'=>'Something went wrong!'], 500);
        }
    }
}
