<?php

namespace App\Http\Controllers\Api;

use App\Group;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class GroupController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/groups/of/{user_id}?page={page}",
     * summary="Get groups of the user ( this user is owner of that groups)",
     * description="
    There are fields:
    -current_page - current page that requested;
    - data - array with groups
    - first_page_url - url that should be requested to get data of first page
    - from - from which record we get next part of data
    - to  - to which record we will fetch data ( for example from:1, to: 20 - this is 1 page)
    - per_page - number of records per page ( always will be 20)
    - last_page_url - page that was called before ( this is not previous page)
    - next_page_url - url for next page
    - prev_page_url - url for previous page
    - total - total count of all records
    ",
     * operationId="getUserGroups",
     * tags={"groups"},
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
     * @OA\Parameter(
     *          name="user_id",
     *          in="path",
     *          description="User id",
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
    "id": 2,
    "owner_id": 30,
    "title": "ddddd",
    "description": "sdsdsdsd",
    "created_at": "2020-12-14 21:38:15",
    "updated_at": "2020-12-14 21:38:15"
    },
    {
    "id": 3,
    "owner_id": 30,
    "title": "dddddeee",
    "description": "sdsdsdsd",
    "created_at": "2020-12-14 21:38:15",
    "updated_at": "2020-12-14 21:38:15"
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
     * @OA\Response(
     *    response=404,
     *    description="Not Found",
     *    @OA\JsonContent(
     *       @OA\Property(property="error", type="string", example="This user not found")
     *     )
     * )
     * )
     */
    public function getUserGroups(int $user_id)
    {
        try {
            $user = User::findOrFail($user_id);
            return response()->json($user->groups()->paginate(20),200);
        }catch (\Exception $exception){
            return response()->json(['error' => 'This user not found'],404);
        }
    }

    /**
     * @OA\Post(
     * path="/api/groups",
     * summary="Create new feed",
     * description="",
     * operationId="postUsersGroup",
     * tags={"groups"},
     * security={ {"bearer": {}} },
     *  @OA\RequestBody(
     *    required=true,
     *    description="Pass group data",
     *     @OA\JsonContent(
     *       required={"title","description"},
     *       @OA\Property(property="title", type="string", format="text", example="Title 1"),
     *       @OA\Property(property="description", type="string", format="text", example="Body 1"),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(property="success", type="string", example="Group successfully created")
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
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|unique:groups',
            'description' => 'required|string',
        ]);
        if ($validator->fails()) {
            return new Response($validator->errors(), 400);
        }
        if(Group::create(array_merge(['owner_id' => auth()->user()->id],$request->all()))){
            return new Response(['success'=>'Group successfully added'], 200);
        }else{
            return new Response(['error'=>'Something went wrong!'], 500);
        }
    }

    /**
     * @OA\Get(
     * path="/api/groups?page={page}",
     * summary="Get all groups",
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
     * operationId="getUsersGroups",
     * tags={"groups"},
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
    "id": 2,
    "owner_id": 30,
    "title": "ddddd",
    "description": "sdsdsdsd",
    "created_at": "2020-12-14 21:38:15",
    "updated_at": "2020-12-14 21:38:15"
    },
    {
    "id": 3,
    "owner_id": 30,
    "title": "dddddeee",
    "description": "sdsdsdsd",
    "created_at": "2020-12-14 21:38:15",
    "updated_at": "2020-12-14 21:38:15"
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
        $groups = Group::paginate(20);
        return response()->json($groups->toArray(),200);
    }


    /**
     * @OA\Get(
     * path="/api/groups/{id}",
     * summary="Get one group(can be used when editing some group)",
     * description="",
     * operationId="getUsersGroup",
     * tags={"groups"},
     * security={ {"bearer": {}} },
     * @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Group id",
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
     *       @OA\Property(property="id", type="int", example="3"),
     *      @OA\Property(property="owner_id", type="int", example="2"),
     *      @OA\Property(property="title", type="string", example="Title"),
     *      @OA\Property(property="description", type="string", example="description"),
     *      @OA\Property(property="created_at", type="string", example="2020-11-23 19:54:26"),
     *      @OA\Property(property="updated_at", type="string", example="2020-11-23 19:54:26"),
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
    public function show(int $group_id)
    {
        try {
            $group = Group::findOrFail($group_id);
            return response()->json($group,200);
        }catch (\Exception $exception){
            return response()->json(['error'=>'Group not found'],404);
        }
    }


    /**
     * @OA\Put(
     * path="/api/groups/{id}",
     * summary="Update group",
     * description="",
     * operationId="putUsersGroup",
     * tags={"groups","test"},
     * security={ {"bearer": {}} },
     * @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Group id",
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
     *       required={"title","description"},
     *       @OA\Property(property="title", type="string", format="text", example="Title 1"),
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
    public function update(Request $request, Group $group)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|unique:groups',
            'description' => 'required|string',
        ]);
        if ($validator->fails()) {
            return new Response($validator->errors(), 400);
        }
        $user = auth()->user();
        if($user->id == $group->owner_id){
            $group->update($request->all());
            return new Response(['success'=>'Group successfully updated'], 200);
        }else{
            return new Response(['error'=>'This action is unauthorized'], 403);
        }

    }


    /**
     * @OA\Delete(
     * path="/api/groups/{id}",
     * summary="Delete group",
     * description="",
     * operationId="deleteUsersGroup",
     * tags={"groups"},
     * security={ {"bearer": {}} },
     * @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Group id",
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
    public function destroy(int $group_id)
    {
        try{
            $group = Group::findOrFail($group_id);
            $user = auth()->user();
            if($user->id == $group->owner_id){
                $group->delete();
                return new Response(['success'=>'Group successfully deleted'], 200);
            }else{
                return new Response(['error'=>'This action is unauthorized'], 403);
            }
        }catch (\Exception $exception){
            return response()->json(['error'=>'Group not found'],404);
        }
    }
}
