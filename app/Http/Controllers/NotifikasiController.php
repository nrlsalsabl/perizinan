<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterNotifikasi;
use App\Models\Outbox;

class NotifikasiController extends Controller
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

        return view('notifikasi.master-notifikasi', compact('masterNotifikasis'));
    }

    public function create()
    {
        return view('notifikasi.create');
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
        return view('notifikasi.edit', compact('masterNotifikasi'));
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

    public function masterNotifikasi(Request $request)
    {
        $search = $request->input('search');

        $masterNotifikasis = MasterNotifikasi::query()
            ->where('category', 'LIKE', "%{$search}%")
            ->orWhere('text_sms', 'LIKE', "%{$search}%")
            ->orWhere('text_email', 'LIKE', "%{$search}%")
            ->orWhere('subject_email', 'LIKE', "%{$search}%")
            ->paginate(10);

        return view('notifikasi.master-notifikasi', compact('masterNotifikasis'));
    }

    public function outbox()
    {
        $outboxes = Outbox::all();
        return view('notifikasi.outbox', compact('outboxes'));
    }

    public function createOutbox()
    {
        return view('notifikasi.create-outbox');
    }

    public function storeOutbox(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:255',
            'text_sms' => 'required|string',
            'text_email' => 'required|string',
            'subject_email' => 'required|string|max:255',
        ]);

        Outbox::create($request->all());

        return redirect()->route('notifikasi.outbox')->with('success', 'Outbox message created successfully.');
    }

    public function editOutbox($id)
    {
        $outbox = Outbox::findOrFail($id);
        return view('notifikasi.edit-outbox', compact('outbox'));
    }

    public function updateOutbox(Request $request, $id)
    {
        $request->validate([
            'category' => 'required|string|max:255',
            'text_sms' => 'required|string',
            'text_email' => 'required|string',
            'subject_email' => 'required|string|max:255',
        ]);

        $outbox = Outbox::findOrFail($id);
        $outbox->update($request->all());

        return redirect()->route('outbox.index')->with('success', 'Outbox message updated successfully.');
    }

    public function destroyOutbox($id)
    {
        $outbox = Outbox::findOrFail($id);
        $outbox->delete();

        return redirect()->route('outbox.index')->with('success', 'Outbox message deleted successfully.');
    }
}
