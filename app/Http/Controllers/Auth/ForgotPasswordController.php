<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Mail\ResetPassword;

class ForgotPasswordController extends Controller
{
    public function showForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        // Generate token manual
        $token = Str::random(60);
        
        // Simpan token ke database
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'email' => $user->email,
                'token' => Hash::make($token),
                'created_at' => now()
            ]
        );

        $resetUrl = url('/reset-password/' . $token . '?email=' . $user->email);

        // Kirim email
        // Mail::raw("Halo,\n\nKlik link berikut untuk reset password:\n\n$resetUrl\n\nLink ini akan expire dalam 60 menit.\n\nTerima kasih.", function ($message) use ($user) {
        //     $message->to($user->email);
        //     $message->subject('Reset Password - ' . config('app.name'));
        // });

        $content = "Halo,\n\nKlik link berikut untuk reset password:\n\n$resetUrl\n\nLink ini akan expire dalam 60 menit.\n\nTerima kasih.";
        $to = $user->email;
        $subject = 'Reset Password - ' . config('app.name');
        $mailData = [
            'to' => $to,
            'content' => $content,
            'subject' => $subject
        ];
        $send = Mail::to($to)->send(new ResetPassword($mailData));
        // $send = mail($to, $subject, $content);
        // dd($send);
        // exit;
        
        return back()->with('status', 'Email reset password telah dikirim ke ' . $user->email);
    }
}