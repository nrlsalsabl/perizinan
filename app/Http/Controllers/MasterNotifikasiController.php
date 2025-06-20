<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterNotifikasi;

class MasterNotifikasiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $masterNotifikasis = MasterNotifikasi::query()
            ->where('category', 'LIKE', "%{$search}%")
            ->orWhere('text_sms', 'LIKE', "%{$search}%")
            ->orWhere('text_email', 'LIKE', "%{$search}%")
            ->orWhere('subject_email', 'LIKE', "%{$search}%")
            ->paginate(10);

        return view('notifikasi.master-notifikasi.index', compact('masterNotifikasis'));
    }

    public function create()
    {
        return view('notifikasi.master-notifikasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:255',
            'text_sms' => 'required|string',
            'text_email' => 'required|string',
            'subject_email' => 'required|string|max:255',
        ]);

        MasterNotifikasi::create($request->all());

        return redirect()->route('master-notifikasi.index')->with('success', 'Master Notifikasi created successfully.');
    }

    public function edit($id)
    {
        $masterNotifikasi = MasterNotifikasi::findOrFail($id);
        return view('notifikasi.master-notifikasi.edit', compact('masterNotifikasi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category' => 'required|string|max:255',
            'text_sms' => 'required|string',
            'text_email' => 'required|string',
            'subject_email' => 'required|string|max:255',
        ]);

        $masterNotifikasi = MasterNotifikasi::findOrFail($id);
        $masterNotifikasi->update($request->all());

        return redirect()->route('master-notifikasi.index')->with('success', 'Master Notifikasi updated successfully.');
    }

    public function destroy($id)
    {
        $masterNotifikasi = MasterNotifikasi::findOrFail($id);
        $masterNotifikasi->delete();

        return redirect()->route('master-notifikasi.index')->with('success', 'Master Notifikasi deleted successfully.');
    }
}
