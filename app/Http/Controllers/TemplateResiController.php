<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TemplateResi;

class TemplateResiController extends Controller
{
    public function index()
    {
        $templateResis = TemplateResi::all();
        return view('pengaturan.template-resi', compact('templateResis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'keterangan' => 'required|string|max:255',
            'file_path' => 'required|mimes:doc,docx|max:10240',
        ]);

        $path = $request->file('file_path')->store('template_resi');

        TemplateResi::create([
            'keterangan' => $request->keterangan,
            'file_path' => $path,
        ]);

        return redirect()->route('template-resi.index')->with('success', 'Template Resi uploaded successfully');
    }

    public function destroy($id)
    {
        $templateResi = TemplateResi::findOrFail($id);
        $templateResi->delete();

        return redirect()->route('template-resi.index')->with('success', 'Template Resi deleted successfully');
    }
}
