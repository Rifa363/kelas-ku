<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\StrukturKelas;

class StrukturController extends Controller
{
    public function index()
    {
        $inti = StrukturKelas::with('user')
            ->whereNull('parent_id')
            ->orderBy('urutan')
            ->get();

        $struktur = $inti->map(function ($item) {
            $item->load('children.user');
            return $item;
        });

        $mahasiswa = collect();
        $jabatanInti = collect();

        if (auth()->check() && auth()->user()->isAdmin()) {
            $mahasiswa = Mahasiswa::orderBy('nama')->get();
            $jabatanInti = StrukturKelas::whereNull('parent_id')->orderBy('urutan')->get();
        }

        return view('struktur.index', compact('struktur', 'mahasiswa', 'jabatanInti'));
    }
}
