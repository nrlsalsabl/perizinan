<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SessionController extends Controller
{
    public function saveCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|numeric'
        ]);

        $sessionId = Session::getId();
        $userId = auth()->check() ? auth()->id() : null;
        $ipAddress = $request->ip();
        $userAgent = $request->header('User-Agent');
        $payload = json_encode(['email' => $request->email, 'code' => $request->code]);
        $lastActivity = now()->timestamp;

        Session::put('generated_code', $request->code);

       // Save the code in session or perform any necessary logic
       Session::put('verification_code', $request->code);

       return response()->json(['success' => true]);
    }
}

