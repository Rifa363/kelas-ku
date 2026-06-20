<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Mahasiswa;
use App\Models\Post;
use App\Models\Notification;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user', 'comments', 'reactions')->latest()->paginate(10);
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(StorePostRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        if ($request->hasFile('lampiran')) {
            $data['lampiran'] = $request->file('lampiran')->store('lampiran', 'public');
        }

        $post = Post::create($data);

        $posterName = auth()->user()->nama;
        $postTitle = $post->judul;

        $allUsers = Mahasiswa::where('id', '!=', auth()->id())->get();

        foreach ($allUsers as $user) {
            Notification::create([
                'user_id' => $user->id,
                'judul' => 'Postingan Baru',
                'pesan' => $posterName . ' membuat postingan "' . $postTitle . '".',
                'type' => 'postingan_baru',
                'post_id' => $post->id,
            ]);
        }

        return redirect()->route('posts.show', $post)
            ->with('success', 'Postingan berhasil dibuat.');
    }

    public function show(Post $post)
    {
        $post->load('user', 'comments.user', 'comments.replies.user', 'reactions');
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $data = $request->validated();

        if ($request->hasFile('lampiran')) {
            if ($post->lampiran) {
                Storage::disk('public')->delete($post->lampiran);
            }
            $data['lampiran'] = $request->file('lampiran')->store('lampiran', 'public');
        }

        $post->update($data);

        return redirect()->route('posts.show', $post)
            ->with('success', 'Postingan berhasil diperbarui.');
    }

    public function destroy(Post $post)
    {
        if ($post->lampiran) {
            Storage::disk('public')->delete($post->lampiran);
        }

        $post->delete();

        return redirect()->route('posts.index')
            ->with('success', 'Postingan berhasil dihapus.');
    }
}
