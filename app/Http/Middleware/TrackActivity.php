<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class TrackActivity
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()) {
            $user = $request->user();
            $today = now()->toDateString();
            $now = now();

            $log = DB::table('activity_logs')
                ->where('user_id', $user->id)
                ->where('date', $today)
                ->first();

            if ($log) {
                DB::table('activity_logs')
                    ->where('id', $log->id)
                    ->update([
                        'page_views' => $log->page_views + 1,
                        'last_activity_at' => $now,
                    ]);
            } else {
                DB::table('activity_logs')->insert([
                    'user_id' => $user->id,
                    'date' => $today,
                    'page_views' => 1,
                    'first_activity_at' => $now,
                    'last_activity_at' => $now,
                ]);
            }

            $user->forceFill(['last_activity_at' => $now])->save();
        }

        return $next($request);
    }
}
