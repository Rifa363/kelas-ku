<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMahasiswa = Mahasiswa::count();
        $totalPosts = Post::count();
        $totalComments = Comment::count();

        $today = now()->toDateString();
        $weekAgo = now()->subDays(7)->toDateString();
        $monthAgo = now()->subDays(30)->toDateString();

        $dailyActivity = DB::table('activity_logs')
            ->selectRaw('date, COUNT(DISTINCT user_id) as active_users')
            ->where('date', '>=', now()->subDays(13)->toDateString())
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('active_users', 'date');

        $activityDates = collect();
        $activityCounts = collect();
        for ($i = 13; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $activityDates->push($date);
            $activityCounts->push($dailyActivity->get($date, 0));
        }

        $activeToday = Mahasiswa::whereDate('last_activity_at', $today)->count();
        $activeWeek = Mahasiswa::where('last_activity_at', '>=', $weekAgo)->count();
        $activeMonth = Mahasiswa::where('last_activity_at', '>=', $monthAgo)->count();
        $inactive = Mahasiswa::where(function ($q) use ($monthAgo) {
            $q->where('last_activity_at', '<', $monthAgo)
              ->orWhereNull('last_activity_at');
        })->count();

        return view('dashboard.index', compact(
            'totalMahasiswa', 'totalPosts', 'totalComments',
            'activityDates', 'activityCounts',
            'activeToday', 'activeWeek', 'activeMonth', 'inactive'
        ));
    }
}
