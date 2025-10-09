<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function showVerifyEmailNotice()
    {
        return view('auth.emails.verify-email');
    }

    public function verifyEmail(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return redirect()->route('dashboard')->with('status', 'E-mail verificado com sucesso!');
    }

    public function sendEmailVerificationNotification(Request $request)
    {
        if($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard'));
        }
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Link de verificação reenviado!');
    }
}
