<?php

namespace App\Controllers;

use Sakuci\Controller;
use Sakuci\Http\Request;
use App\Models\Lokasi;

class LokasiController extends Controller
{
    public function index(Request $request)
    {
       $lokasi = lokasi::orderBy('id_lokasi', 'desc')->paginate(5);
       return view ('lokasi.index', compact('lokasi'));
    }

    public function create(Request $request)
    {
        return view('lokasi.create');
    }
 
    public function store(Request $request)
    {
        $request->validate([
            'nama_lokasi' => 'required|string|max:255',
        ]);

        lokasi::create([
            'nama_lokasi' => $request->input('nama_lokasi'),
        ]);

        return redirect()->route('admin.lokasi.index')->with('success', 'lokasi berhasil ditambahkan.');
    }

    public function edit($id_lokasi)
    {
        $lokasi = lokasi::findOrFail($id_lokasi);
        return $this->view('lokasi.edit', compact('lokasi'));
    }

    public function update(Request $request, $id_lokasi)
    {
        $request->validate([
            'nama_lokasi' => 'required|string|max:255',
        ]);

        $lokasi = lokasi::findOrFail($id_lokasi);
        $lokasi->update([
            'nama_lokasi' => $request->input('nama_lokasi'),
        ]);

        return redirect()->route('admin.lokasi.index')->with('success', 'lokasi berhasil diperbarui.');
    }

    public function delete(Request $request, $id)
    {
        $lokasi = lokasi::findOrFail($id);
        $lokasi->delete();

        return redirect()->route('admin.lokasi.index')->with('success', 'Kategori berhasil dihapus.');
    } 
}