<?php

namespace App\Http\Controllers;

use App\Models\AccountPemohon;
use Illuminate\Http\Request;

class AccountPemohonController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $accountPemohon = AccountPemohon::query()
            ->where('name', 'LIKE', "%{$search}%")
            ->orWhere('nik', 'LIKE', "%{$search}%")
            ->paginate(10);

        return view('account-pemohon.index', compact('accountPemohon'));
    }

    // Add methods for edit and delete if necessary
}