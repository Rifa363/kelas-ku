<?php

namespace App\Http\Controllers;

use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->latest()
            ->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    public function redirect(Notification $notification)
    {
        abort_if($notification->user_id !== auth()->id(), 403);

        $notification->update(['status' => 'read']);

        if ($notification->post_id) {
            $url = route('posts.show', $notification->post_id);
            if ($notification->comment_id) {
                $url .= '#comment-' . $notification->comment_id;
            }
            return redirect($url);
        }

        return redirect()->route('notifications.index');
    }

    public function read(Notification $notification)
    {
        abort_if($notification->user_id !== auth()->id(), 403);

        $notification->update(['status' => 'read']);

        return back();
    }

    public function readAll()
    {
        Notification::where('user_id', auth()->id())
            ->where('status', 'unread')
            ->update(['status' => 'read']);

        return back()->with('success', 'Semua notifikasi telah dibaca.');
    }
}
