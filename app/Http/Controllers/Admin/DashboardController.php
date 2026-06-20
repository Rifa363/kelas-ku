<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Mahasiswa;
use App\Models\Post;
use App\Models\StrukturKelas;
use App\Models\Notification as Notif;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMahasiswa = Mahasiswa::count();
        $totalPosts = Post::count();
        $totalNotifications = Notif::count();
        $recentNotifications = Notif::latest()->take(5)->get();
        $totalStruktur = StrukturKelas::count();

        return view('admin.dashboard', compact(
            'totalMahasiswa', 'totalPosts', 'totalNotifications', 'recentNotifications', 'totalStruktur'
        ));
    }
}
