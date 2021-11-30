<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use App\Models\User;

class EmailController extends Controller
{
    public function verify(Request $request){
        $userID = $request['id'];
        $user = User::findOrFail($userID);
        $date = date("Y-m-d g:i:s");
        $user->email_verified_at = $date; // to enable the "email_verified_at field of that user be a current time stamp by mimicing the must verify email feature
        $user->save();
        return redirect()->to('http://localhost:8082/login?verified=success');
    }

    public function resend(Request $request){
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json('User already have verified email!', 422);
            // return redirect($this->redirectPath());
        }
        $request->user()->sendEmailVerificationNotification();
        return response()->json('The notification has been resubmitted');
        // return back()->with('resent', true);
    }

}
