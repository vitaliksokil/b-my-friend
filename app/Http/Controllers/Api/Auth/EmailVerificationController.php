<?php

namespace App\Http\Controllers\Api\Auth;

use App\Events\SendEmailVerificationEvent;
use App\Services\EmailService\EmailServiceInterface;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class EmailVerificationController extends Controller
{

    /**
     * @OA\Post(
     * path="/api/email/send-verification ",
     * summary="Send email verification",
     * description="Sending email with verification token to user's email",
     * operationId="emailSend",
     * tags={"email"},
     *  security={ {"bearer": {}} },
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
     *       @OA\Property(property="message", type="object", example="Something went wrong! Your email has been already confirmed!")
     *        )
     *     )
     * )
     */
    public function sendEmailVerification()
    {
        $user = auth()->user();
        $to_email = $user->email;
        $token = Str::random(30);
        $data = [
            'token'=> $token,
            'user_id' => $user->id
        ];
        if(!isset($user->email_verified_at)) {
            try {
                /** @var EmailServiceInterface $emailService */
                $emailService = app()->make(EmailServiceInterface::class);
                $emailService->send('emails.email-verification.emailVerification','Email Verification',$data,$to_email);

                $user->email_verification_token = $token;
                if ($user->save()) {
                    return new Response(['message' => 'Email verification was successfully sent on ' . $to_email], 200);
                } else {
                    return new Response(['message' => 'Something went wrong'], 500);
                }
            } catch (\Exception $exception) {
                return new Response(['message' => $exception->getMessage()], 500);
            }
        }else{
            return new Response(['message' => 'Something went wrong! Your email has been already confirmed!'], 400);
        }
    }


    // not api
    public function emailVerification(string $token,int $user_id){
        $user = User::find($user_id);
        if($user instanceof User && $user->email_verification_token == $token){
            $user->email_verification_token = null;
            $user->email_verified_at = new \DateTime('now');
            if($user->save()){
                return view('emails.email-verification.messageWithVerified', [
                        'success' => 'Successfully verified'
                ]);
            }else{
                return view('emails.messageWithVerified', [
                    'error' => 'Something went wrong'
                ]);
            }
        }else{
            return view('emails.messageWithVerified', [
                'error' => 'Incorrect token'
            ]);
        }
    }
}
