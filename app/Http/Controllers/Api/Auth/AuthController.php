<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     * path="/api/auth/register",
     * summary="Sign up",
     * description="Register by name, email, password",
     * operationId="authRegister",
     * tags={"auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user's data",
     *    @OA\JsonContent(
     *       required={"name", "email","password"},
     *       @OA\Property(property="name", type="string", format="text", example="Nick"),
     *       @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
     *       @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
     *
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(property="user", type="object", example={
    "id": 1,
    "name":"test",
    "email": "testt@gmail.com",
    "email_verified_at": null,
    })
     *        )
     *     ),
     *
     * @OA\Response(
     *    response=400,
     *    description="Error",
     *    @OA\JsonContent(
     *       @OA\Property(property="password", type="object", example={
    "The password must be at least 6 characters."
    })
     *        )
     *     )
     * )
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        if ($validator->fails()) {
            return new Response($validator->errors(), 400);
        }
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();
            return new Response(['user' => $user], 200);
        }catch (\Exception $exception){
            return new Response(['email'=>['User with this email already exists']], 400);
        }
    }

    /**
     * @OA\Post(
     * path="/api/auth/login",
     * summary="Sign in",
     * description="Login by email, password",
     * operationId="authLogin",
     * tags={"auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"email","password"},
     *       @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
     *       @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
     *    ),
     * ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="access_token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9iLW15LWZyaWVuZC5sb2NcL2FwaVwvYXV0aFwvbG9naW4iLCJpYXQiOjE2MDQwMDIxOTcsImV4cCI6MTYwNDAwNTc5NywibmJmIjoxNjA0MDAyMTk3LCJqdGkiOiJyb2RINmdBVklOMU9OSk5TIiwic3ViIjoxLCJwcnYiOiI4N2UwYWYxZWY5ZmQxNTgxMmZkZWM5NzE1M2ExNGUwYjA0NzU0NmFhIn0.O-uXG80fluNYYTWkK5-jCMZV74LPjd8_hi0V4RAzTrg"),
     *              @OA\Property(property="user", type="object", example={
    "id": 1,
    "name": "test",
    "email": "testt@gmail.com",
    "email_verified_at": null
     *             }),
     *             @OA\Property(property="token_type", type="string", example="bearer"),
     *          )
     *      ),
     *
     * @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     *        )
     *     )
     * )
     */
    public function login()
    {
        $credentials = request(['email', 'password']);
        if (!$token = auth('api')->attempt($credentials)) {
            return new Response(['error' => "Sorry, wrong email address or password. Please try again"], 422);
        }
        return $this->respondWithToken($token);
    }

    /**
     * @OA\Post(
     *      path="/api/auth/me",
     *      summary="Testing token",
     *      description="Requires 'Authorization' header with bearer token",
     *      operationId="authMe",
     *      tags={"auth"},
     *      security={ {"bearer": {}} },
     *      @OA\Response(
     *          response=200,
     *          description="Returns auth user",
     *          @OA\JsonContent(
     *              @OA\Property(property="user", type="object", example={
                    "id": 1,
                    "name": "test",
                    "email": "testt@gmail.com",
                    "email_verified_at": null
     *             }),
     *          )
     *        ),
     *     @OA\Response(
     *          response=403,
     *          description="Error. Forbidden",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="object", example="Unauthenticated"),
     *          )
     *        ),
     *
     *    )
     */
    public function me()
    {
        return response()->json(['user'=>auth('api')->user()]);
    }


    /**
     * @OA\Post(
     * path="/api/auth/logout",
     * summary="Logout",
     * description="Logout",
     * operationId="authLogout",
     * tags={"auth"},
     * security={ {"bearer": {}} },
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *              @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Successfully logged out"),
     *          )
     *      ),
     *     @OA\Response(
     *          response=403,
     *          description="Error. Forbidden",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="object", example="Unauthenticated"),
     *          )
     *        ),
     *)
     */
    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'Successfully logged out'],200);
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'user' => $this->guard()->user(),
            'token_type' => 'bearer'
        ]);
    }

    public function guard()
    {
        return \Auth::Guard('api');
    }
}
