<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStrukturRequest;
use App\Http\Requests\UpdateStrukturRequest;
use App\Models\Mahasiswa;
use App\Models\StrukturKelas;
use Illuminate\Support\Facades\Storage;

class StrukturController extends Controller
{
    public function index()
    {
        $struktur = StrukturKelas::with('user', 'parent')
            ->orderBy('urutan')
            ->paginate(20);

        return view('admin.struktur.index', compact('struktur'));
    }

    public function create()
    {
        $mahasiswa = Mahasiswa::orderBy('nama')->get();
        $jabatan = StrukturKelas::whereNull('parent_id')->orderBy('urutan')->get();
        return view('admin.struktur.create', compact('mahasiswa', 'jabatan'));
    }

    public function store(StoreStrukturRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('struktur', 'public');
        }

        StrukturKelas::create($data);

        return redirect()->route('struktur-kelas.index')
            ->with('success', 'Anggota struktur berhasil ditambahkan.');
    }

    public function edit(StrukturKelas $struktur)
    {
        $mahasiswa = Mahasiswa::orderBy('nama')->get();
        $jabatan = StrukturKelas::whereNull('parent_id')
            ->where('id', '!=', $struktur->id)
            ->orderBy('urutan')
            ->get();
        return view('admin.struktur.edit', compact('struktur', 'mahasiswa', 'jabatan'));
    }

    public function update(UpdateStrukturRequest $request, StrukturKelas $struktur)
    {
        $data = $request->validated();

        if ($request->hasFile('foto')) {
            if ($struktur->foto) {
                Storage::disk('public')->delete($struktur->foto);
            }
            $data['foto'] = $request->file('foto')->store('struktur', 'public');
        }

        $struktur->update($data);

        return redirect()->route('struktur-kelas.index')
            ->with('success', 'Anggota struktur berhasil diperbarui.');
    }

    public function destroy(StrukturKelas $struktur)
    {
        if ($struktur->foto) {
            Storage::disk('public')->delete($struktur->foto);
        }

        $struktur->delete();

        return redirect()->route('struktur-kelas.index')
            ->with('success', 'Anggota struktur berhasil dihapus.');
    }
}
