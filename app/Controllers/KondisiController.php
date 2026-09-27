<?php

namespace App\Controllers;

use Sakuci\Controller;
use Sakuci\Http\Request;
use App\Models\Kondisi;

class KondisiController extends Controller
{
    public function index(Request $request)
    {
       $kondisi = kondisi::orderBy('id_kondisi', 'desc')->paginate(5);
       return view ('kondisi.index', compact('kondisi'));
    }

    public function create(Request $request)
    {
        return view('kondisi.create');
    }
 
    public function store(Request $request)
    {
        $request->validate([
            'nama_kondisi' => 'required|string|max:255',
        ]);

        kondisi::create([
            'nama_kondisi' => $request->input('nama_kondisi'),
        ]);

        return redirect()->route('admin.kondisi.index')->with('success', 'Kondisi berhasil ditambahkan.');
    }

    public function edit($id_kondisi)
    {
        $kondisi = kondisi::findOrFail($id_kondisi);
        return $this->view('kondisi.edit', compact('kondisi'));
    }

    public function update(Request $request, $id_kondisi)
    {
        $request->validate([
            'nama_kondisi' => 'required|string|max:255',
        ]);

        $kondisi = kondisi::findOrFail($id_kondisi);
        $kondisi->update([
            'nama_kondisi' => $request->input('nama_kondisi'),
        ]);

        return redirect()->route('admin.kondisi.index')->with('success', 'Kondisi berhasil diperbarui.');
    }

    public function delete(Request $request, $id)
    {
        $kondisi = kondisi::findOrFail($id);
        $kondisi->delete();

        return redirect()->route('admin.kondisi.index')->with('success', 'Kondisi berhasil dihapus.');
    } 
}