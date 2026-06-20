<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Mahasiswa;
use App\Models\Post;
use App\Models\Notification;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'komentar' => ['required', 'string'],
            'parent_id' => ['nullable', 'exists:comments,id'],
        ]);

        $comment = Comment::create([
            'post_id' => $post->id,
            'user_id' => auth()->id(),
            'parent_id' => $request->parent_id,
            'komentar' => $request->komentar,
        ]);

        $commenterName = auth()->user()->nama;
        $postTitle = $post->judul;

        $recipients = collect();

        if ($post->user_id !== auth()->id()) {
            $recipients->push($post->user_id);
        }

        $previousCommenterIds = Comment::where('post_id', $post->id)
            ->where('user_id', '!=', auth()->id())
            ->distinct()
            ->pluck('user_id');

        foreach ($previousCommenterIds as $userId) {
            $recipients->push($userId);
        }

        $recipients = $recipients->unique();

        foreach ($recipients as $userId) {
            Notification::create([
                'user_id' => $userId,
                'judul' => 'Komentar Baru',
                'pesan' => $commenterName . ' berkomentar pada "' . $postTitle . '".',
                'type' => 'komentar_baru',
                'post_id' => $post->id,
                'comment_id' => $comment->id,
            ]);
        }

        return redirect()->route('posts.show', $post)
            ->with('success', 'Komentar berhasil ditambahkan.');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return back()->with('success', 'Komentar berhasil dihapus.');
    }
}
