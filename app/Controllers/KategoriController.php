<?php

namespace App\Controllers;

use Sakuci\Controller;
use Sakuci\Http\Request;
use App\Models\Kategori;
class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $kategori = Kategori::orderBy('id_kategori', 'desc')->paginate(10);
        return view('Kategori.index', compact('kategori'));
    }
    public function create(request $request)
    {
        return view('Kategori.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama_keterangan' => 'required|varchar|max:255',
        ]);

        Kategori::create([
            'keterangan' => $request->input('keterangan'),
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }
    public function edit(Request $request, $id_kategori)
    {
        $kategori = Kategori::findOrFail($id_kategori);
        return view('Kategori.edit', compact('kategori'));
    }
    public function update(Request $request, $id_kategori)
    {
        $request->validate([
            'keterangan' => 'required|varcharmax:255',
        ]);

        $kategori = Kategori::findOrFail($id_kategori);
        $kategori->update([
            'keterangan' => $request->input('keterangan'),
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Request $request, $id_kategori)
    {
        $kategori = Kategori::findOrFail($id_kategori);
        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}