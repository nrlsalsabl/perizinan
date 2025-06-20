<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function onlineSingleSubmission()
    {
        return view('online-single-submission');
    }

    public function perizinanOnline()
    {
        return view('perizinan-online');
    }

    public function persyaratan()
    {
        return view('persyaratan');
    }

    public function website()
    {
        return view('website');
    }
}
