<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\rejectData;
use App\Models\requestPendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class frontendController extends Controller
{
   public function index()
{
    // Ambil semua pengajuan yang dimiliki oleh user login
    $userPengajuanIds = requestPendaftaran::where('user_id', Auth::id())
        ->pluck('pengajuan_id')
        ->unique();

    // Ambil SEMUA proses request untuk pengajuan-pengajuan tersebut (termasuk yg dikerjakan Kasi/BackOffice)
    $requestData = requestPendaftaran::whereIn('pengajuan_id', $userPengajuanIds)
        ->orderBy('created_at', 'desc')
        ->get();

    // Ambil status terbaru untuk tiap pengajuan
    $reject = $requestData
        ->groupBy('pengajuan_id')
        ->map(fn($group) => $group->first()) // entri terakhir
        ->values(); // reset index agar bisa di-loop

    return view('monitoring-frontend.index', compact('reject'));
}


    public function show($id)
{
    // Ambil satu data pendaftaran berdasarkan pengajuan_id
    $reject = requestPendaftaran::where('pengajuan_id', $id)->latest()->firstOrFail();

    // Ambil semua detail terkait pengajuan_id
    $detail = requestPendaftaran::where('pengajuan_id', $id)->get();

    // Ambil penolakan
    $penolakan = rejectData::where('pengajuan_id', $id)->orderBy('created_at', 'desc')->first();

    // Ambil lampiran yang tidak valid
    $file = rejectData::where('pengajuan_id', $id)->where('validasi', 'tidak valid')->get();

    return view('monitoring-frontend.show', compact('reject', 'detail', 'penolakan', 'file'));
}

}
