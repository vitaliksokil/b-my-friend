<?php

namespace App\Http\Controllers\Api\Auth;

use App\Services\EmailService\EmailServiceInterface;
use App\Services\ValidatorService\ValidatorServiceInterface;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{

    /**
     * @OA\Post(
     * path="/api/auth/reset-password",
     * summary="Reset Password",
     * description="Reset password by email",
     * operationId="authResetPassword",
     * tags={"auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass email address",
     *    @OA\JsonContent(
     *       required={"email"},
     *       @OA\Property(property="email", type="string", format="email", example="user1@gmail.com"),
     *    ),
     * ),
    @OA\Response(
     *    response=200,
     *    description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Email with instruction was successfully sent on test@gmail.com")
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
     *       @OA\Property(property="message", type="object", example="User with this email address doesn't exist")
     *        )
     *     )
     *
     * )
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);
        if ($validator->fails()) {
            return new Response($validator->errors(), 400);
        }
        $to_email = $request->email;

        $user = User::where('email', $to_email)->first();
        if ($user instanceof User) {
            $token = Str::random(30);
            $data = [
                'token' => $token,
                'email' => $to_email,
            ];
            try {
                DB::table('password_resets')
                    ->updateOrInsert(
                        ['email' => $to_email],
                        ['token' => $token, 'created_at' => now()]
                    );
                /** @var EmailServiceInterface $emailService */
                $emailService = app()->make(EmailServiceInterface::class);
                $emailService->send('emails.reset-password.emailReset','Reset Password',$data,$to_email);
                return new Response(['message' => 'Email with instruction was successfully sent on ' . $to_email], 200);
            } catch (\Exception $exception) {
                return new Response(['error' => $exception->getMessage()], 500);
            }
        } else {
            return new Response(['error' => 'User with this email address doesn\'t exist'], 400);
        }
    }



    /**
     * @OA\Post(
     * path="/api/auth/android/reset-password",
     * summary="Reset Password",
     * description="Send email for reseting password",
     * operationId="authResetPassword",
     * tags={"android-auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass email address",
     *    @OA\JsonContent(
     *       required={"email"},
     *       @OA\Property(property="email", type="string", format="email", example="user1@gmail.com"),
     *    ),
     * ),
    @OA\Response(
     *    response=200,
     *    description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Email with instruction was successfully sent on test@gmail.com")
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
     *       @OA\Property(property="message", type="object", example="User with this email address doesn't exist")
     *        )
     *     )
     *
     * )
     */
    public function androidResetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);
        if ($validator->fails()) {
            return new Response($validator->errors(), 400);
        }
        $to_email = $request->email;

        $user = User::where('email', $to_email)->first();
        if ($user instanceof User) {
            $code = substr(str_shuffle("0123456789"), 0, 7);
            $data = [
                'code' => $code,
                'email' => $to_email,
            ];
            try {
                DB::table('password_resets')
                    ->updateOrInsert(
                        ['email' => $to_email],
                        ['code' => $code, 'is_android'=>true, 'created_at' => now()]
                    );
                /** @var EmailServiceInterface $emailService */
                $emailService = app()->make(EmailServiceInterface::class);
                $emailService->send('emails.android.reset-password.emailReset','Reset Password',$data,$to_email);
                return new Response(['message' => 'Email with instruction was successfully sent on ' . $to_email], 200);
            } catch (\Exception $exception) {
                return new Response(['error' => $exception->getMessage()], 500);
            }
        } else {
            return new Response(['error' => 'User with this email address doesn\'t exist'], 400);
        }
    }

    /**
     * @OA\Post(
     * path="/api/auth/android/reset-code-check",
     * summary="Check reset code",
     * description="Checking reset code",
     * operationId="authResetCodeCheckAndroid",
     * tags={"android-auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass email address and code",
     *    @OA\JsonContent(
     *       required={"email","code"},
     *       @OA\Property(property="email", type="string", format="email", example="user1@gmail.com"),
     *       @OA\Property(property="code", type="string", format="string", example="4587091"),
     *    ),
     * ),
    @OA\Response(
     *    response=200,
     *    description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(property="success", type="string", example="Code confirmed")
     *        )
     *     ),
     *
     * @OA\Response(
     *    response=400,
     *    description="Error",
     *    @OA\JsonContent(
     *       @OA\Property(property="error", type="object", example="Incorrect code")
     *        )
     *     )
     *
     * )
     */
    public function androidResetCodeCheck(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'code' => 'required',
        ]);
        if ($validator->fails()) {
            return new Response($validator->errors(), 400);
        }
        $passwordResetRow = DB::table('password_resets')->where([
            ['email',$request->email],
            ['code',$request->code]
        ])->first();
        if($passwordResetRow){
            return new Response(['success' => 'Code confirmed'], 200);
        }else{
            return new Response(['error' => 'Incorrect code'], 400);
        }
    }


    /**
     * @OA\Post(
     * path="/api/auth/android/password-change",
     * summary="Change password",
     * description="Enter new password to change it",
     * operationId="authPasswordChangeAndroid",
     * tags={"android-auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass email address, code, password and password confirmation",
     *    @OA\JsonContent(
     *       required={"email","code","password", "password_confirmation"},
     *       @OA\Property(property="email", type="string", format="email", example="user1@gmail.com"),
     *       @OA\Property(property="code", type="string", format="string", example="4587091"),
     *       @OA\Property(property="password", type="string", example="123456"),
     *       @OA\Property(property="password_confirmation", type="string", example="123456"),
     *    ),
     * ),
    @OA\Response(
     *    response=200,
     *    description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(property="success", type="string", example="Password successfully changed")
     *        )
     *     ),
     *
     * @OA\Response(
     *    response=500,
     *    description="Error",
     *    @OA\JsonContent(
     *       @OA\Property(property="error", type="object", example="Incorrect email or code! Try again")
     *        )
     *     )
     *
     * )
     */
    public function androidChangePassword(Request $request){
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6|confirmed',
            'email' => 'required',
            'code' => 'required'
        ]);
        if ($validator->fails()) {
            return new Response($validator->errors(), 400);
        }

        $passwordResetRow = DB::table('password_resets')->where([
            ['email',$request->email],
            ['code',$request->code]
        ])->first();
        if($passwordResetRow){
            $user = User::where('email',$request->email)->first();
            $user->password = bcrypt($request->password);
            if($user->update()){
                DB::table('password_resets')->where([
                    ['email',$request->email],
                    ['code',$request->code]
                ])->delete();

                return new Response(['success' => 'Password successfully changed'], 200);
            }
        }else{
            return new Response(['error' => 'Incorrect email or code! Try again'], 500);
        }
    }



    // not api
    public function passwordReset(string $token, string $email){
        $passwordResetRow = DB::table('password_resets')->where([
            ['email',$email],
            ['token',$token]
        ])->first();
        if($passwordResetRow){
            return view('auth.reset-password.reset-password',[
                'email' => $email,
                'token' => $token
            ]);
        }else{
            return view('auth.reset-password.message',['error' => 'Incorrect email or token!!!']);
        }
    }
    public function changePassword(Request $request){
        $request->validate([
            'password' => 'required| min:6|confirmed'
        ]);
        $passwordResetRow = DB::table('password_resets')->where([
            ['email',$request->email],
            ['token',$request->token]
        ])->first();
        if($passwordResetRow){
            $user = User::where('email',$request->email)->first();
            $user->password = bcrypt($request->password);
            if($user->update()){
                DB::table('password_resets')->where([
                    ['email',$request->email],
                    ['token',$request->token]
                ])->delete();

                return view('auth.reset-password.message',['success'=>'Your password successfully changed!!!']);
            }
        }else{
            return redirect()->back()->withErrors(['Opps... Something went wrong. Try again']);
        }
    }
}
