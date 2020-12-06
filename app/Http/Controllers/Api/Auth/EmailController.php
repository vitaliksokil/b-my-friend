<?php

namespace App\Http\Controllers\Api\Auth;

use App\Services\EmailService\EmailServiceInterface;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class EmailController extends Controller
{


    /**
     * @OA\Post(
     * path="/api/email/change ",
     * summary="Change email",
     * description="",
     * operationId="emailChange",
     * tags={"email"},
     *  security={ {"bearer": {}} },
     * @OA\RequestBody(
     *    required=true,
     *    description="",
     *    @OA\JsonContent(
     *       required={"email","password"},
     *       @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
     *       @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
     *
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Email verification was successfully sent on test@gmail.com")
     *        )
     *     ),
     *
     * @OA\Response(
     *    response=500,
     *    description="Error",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="object", example="Something went wrong when sending email")
     *        )
     *     ),
     * @OA\Response(
     *    response=400,
     *    description="Error",
     *    @OA\JsonContent(
     *       @OA\Property(property="errors", type="object", example={
            "password":{
            "Incorrect password"
            },
    "email":{
    "The email has already been taken."
    },
*     })
     *
     *        )
     *     )
     * )
     */
    public function update(Request $request, EmailServiceInterface $emailService){
        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'email' => 'required|email|unique:users'
        ]);
        if ($validator->fails()) {
            return new Response(['errors'=>$validator->errors()], 400);
        }
        $user = auth()->user();
        if (Hash::check($request->password, $user->password)) {
            $token = Str::random(30);
            $user->email_verified_at = null;
            $user->email = $request->email;
            $user->email_verification_token = $token;
            $user->save();
            $to_email = $user->email;
            $data = [
                'token'=> $token,
                'user_id' => $user->id
            ];
            $emailService->send('emails.email-verification.emailVerification','Email Verification',$data,$to_email);
            return new Response(['message'=>'Message with email verification successfully sent to ' . $to_email], 200);
        }else{
            return new Response(['errors'=>['password'=>['Incorrect password']]], 400);
        }
    }
}
