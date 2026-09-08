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
            'nama' => 'required|string|max:255',
        ]);

        Kategori::create([
            'keterangan' => $request->input('nama'),
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }
    public function edit(Request $request, $kategori)
    {
        $kategori = Kategori::findOrFail($kategori);
        return view('Kategori.edit', compact('kategori'));
    }
    public function update(Request $request, $kategori)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $kategori = Kategori::findOrFail($kategori);
        $kategori->update([
            'keterangan' => $request->input('nama'),
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }
}