<?php

namespace App\Http\Controllers;

use App\Models\MdBidang;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MdBidangController extends Controller
{
    public function index(Request $request)
    {
        $query = MdBidang::query();
        
        // Handle search
        if ($request->has('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }
        
        $bidangs = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('md_bidang', compact('bidangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $bidang = new MdBidang();
        $bidang->id = (string) Str::uuid(); // Pastikan ID di-cast ke string
        $bidang->nama = $request->nama;
        $bidang->created_by = auth()->id();
        $bidang->save();

        return redirect()->route('bidang.index')->with('success', 'Data bidang berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $bidang = MdBidang::findOrFail($id);
        $bidang->update([
            'nama' => $request->nama,
            'updated_by' => auth()->id()
        ]);

        return redirect()->route('bidang.index')->with('success', 'Data bidang berhasil diupdate');
    }

    public function destroy($id)
    {
        $bidang = MdBidang::findOrFail($id);
        $bidang->update(['deleted_by' => auth()->id()]);
        $bidang->delete();

        return redirect()->route('bidang.index')->with('success', 'Data bidang berhasil dihapus');
    }
}