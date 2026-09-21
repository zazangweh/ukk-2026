<?php

namespace App\Controllers;

use Sakuci\Controller;
use Sakuci\Http\Request;
use app\models\Siswa;
use app\models\User;

class PenggunaController extends Controller
{
    public function index(Request $request)
    {
      $data = Siswa::leftjoin('users','siswa.id_user','=','users.id')
            ->orderBy('siswa.id_siswa','desc')
            ->paginate(5);
            return view ('pengguna.index',compact('data'));
    }
    public function create(Request $request)
    {
        return view('pengguna.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
             'nis' => 'required|string|unique:siswa.nis',
              'kelas' => 'required|string|max:10', 
        ]);
        $user = User::create([
            'username' => $request->nis,
            'password' => password_hash('123456',PASSWORD_DEFAULT),
            'role' => 'siswa',
           
        ]);
        Siswa::create([
            'nama' => $request->nama,
            'nis' => $request->nis,
            'kelas' => $request->kelas,
            'id_user' => $request->id,
        ]);

        return redirect()->route('pengguna.index')->with('succes','pengguna berhasil ditambahkan');
    }
}
