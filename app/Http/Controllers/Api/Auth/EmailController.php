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
    public function update(Request $request, EmailServiceInterface $emailService){
        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'email' => 'required|email'
        ]);
        if ($validator->fails()) {
            return new Response($validator->errors(), 400);
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
            return new Response(['error'=>'Incorrect password'], 400);
        }
    }
}
