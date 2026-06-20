<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Reaction;
use Illuminate\Http\Request;

class ReactionController extends Controller
{
    public function toggle(Request $request, Post $post)
    {
        $request->validate([
            'reaction' => ['required', 'in:like,dislike'],
        ]);

        $existing = Reaction::where('post_id', $post->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($existing) {
            if ($existing->reaction === $request->reaction) {
                $existing->delete();
            } else {
                $existing->update(['reaction' => $request->reaction]);
            }
        } else {
            Reaction::create([
                'post_id' => $post->id,
                'user_id' => auth()->id(),
                'reaction' => $request->reaction,
            ]);
        }

        return back();
    }
}
