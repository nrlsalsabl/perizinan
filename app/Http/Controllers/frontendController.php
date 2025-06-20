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
        // Ambil ID pengguna yang sedang login
        $userId = Auth::id();

        // Ambil data terakhir dari setiap pengajuan_id untuk user yang login
        $reject = requestPendaftaran::where('user_id', $userId)
            ->orderBy('created_at', 'asc') // Urutkan berdasarkan waktu terbaru
            ->get()
            ->unique('pengajuan_id'); // Ambil hanya data unik berdasarkan pengajuan_id



        return view('monitoring-frontend.index', compact('reject'));
    }

    public function show($id)
    {
        $reject = requestPendaftaran::findOrFail($id);
        $detail = requestPendaftaran::where('pengajuan_id', $id)->get();
        $penolakan = rejectData::where('pengajuan_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();
        $file = rejectData::where('validasi', 'tidak valid')
            ->get();
       // dd($reject);
        // dd($reject);
        return view('monitoring-frontend.show', compact('reject', 'detail', 'penolakan', 'file'));
    }
}
