<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MahasiswaController extends Controller
{
    // Halaman utama / index
    public function index(Request $request)
    {
        $request->flash();
        $mahasiswa = Mahasiswa::query();

        // Pencarian mahasiswa
        if($request->keyword) {
            $mahasiswa = $mahasiswa->where(function($query) use ($request) {
                $query->where('nama', 'LIKE', "%{$request->keyword}%")
                      ->orWhere('npm', 'LIKE', "%{$request->keyword}%")
                      ->orWhere('jurusan', 'LIKE', "%{$request->keyword}%");
            });
        }
        
        $mahasiswa = $mahasiswa->latest()->get();
        return view('admin.mahasiswa.index', compact('mahasiswa'));
    }

    // Halaman tambah
    public function create()
    {
        return view('admin.mahasiswa.create');
    }

    // Proses simpan data mahasiswa
    public function store(Request $request)
    {
        // Validasi input
        $this->validate($request, [
            'npm' => 'required|unique:mahasiswa,npm|max:10',
            'nama' => 'required|string|max:255',
            'jurusan' => 'required|in:TI,SI',
            'tanggal_lahir' => 'required|date',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        try {
            $input = $request->all();

            // Handle upload foto
            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $nama_foto = time() . '_' . Str::slug($request->nama) . '.' . $foto->getClientOriginalExtension();
                
                // Pindahkan foto ke storage
                $foto->move(public_path('storage/mahasiswa'), $nama_foto);
                $input['foto'] = $nama_foto;
            }

            // Buat data mahasiswa baru
            Mahasiswa::create($input);

            return redirect()->route('mahasiswa.index')
                           ->with('success', 'Data mahasiswa berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    // Halaman edit
    public function edit($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        return view('admin.mahasiswa.edit', compact('mahasiswa'));
    }

    // Proses update data
    public function update(Request $request, $id)
    {
        // Validasi input
        $this->validate($request, [
            'npm' => 'required|max:10|unique:mahasiswa,npm,' . $id,
            'nama' => 'required|string|max:255',
            'jurusan' => 'required|in:TI,SI',
            'tanggal_lahir' => 'required|date',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        try {
            $mahasiswa = Mahasiswa::findOrFail($id);
            $input = $request->all();

            // Handle upload foto
            if ($request->hasFile('foto')) {
                // Hapus foto lama jika ada
                if ($mahasiswa->foto && file_exists(public_path('storage/mahasiswa/'.$mahasiswa->foto))) {
                    unlink(public_path('storage/mahasiswa/'.$mahasiswa->foto));
                }

                // Upload foto baru
                $foto = $request->file('foto');
                $nama_foto = time() . '_' . Str::slug($request->nama) . '.' . $foto->getClientOriginalExtension();
                $foto->move(public_path('storage/mahasiswa'), $nama_foto);
                $input['foto'] = $nama_foto;
            }

            // Update data mahasiswa
            $mahasiswa->update($input);

            return redirect()->route('mahasiswa.index')
                           ->with('success', 'Data mahasiswa berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }

    // Proses delete data
    public function delete($id)
    {
        try {
            $mahasiswa = Mahasiswa::findOrFail($id);

            // Hapus foto jika ada
            if ($mahasiswa->foto && file_exists(public_path('storage/mahasiswa/'.$mahasiswa->foto))) {
                unlink(public_path('storage/mahasiswa/'.$mahasiswa->foto));
            }

            // Hapus data mahasiswa
            $mahasiswa->delete();

            return redirect()->route('mahasiswa.index')
                           ->with('success', 'Data mahasiswa berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }

    // Cetak data mahasiswa
    public function print()
    {
        $mahasiswa = Mahasiswa::orderBy('nama', 'asc')->get();
        return view('admin.mahasiswa.print', compact('mahasiswa'));
    }

    // Helper function untuk mengecek dan membuat direktori
    private function checkAndCreateDirectory()
    {
        $path = public_path('storage/mahasiswa');
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
    }
}