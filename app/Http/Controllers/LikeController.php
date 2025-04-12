<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LikeController extends Controller
{
    public function toggle(Request $request, Post $post)
    {
        $user = Auth::user();

        Log::info("User {$user->id} toggles like on post {$post->id}");

        $like = $post->likes()->where('user_id', $user->id)->first();

        if ($like) {
            $like->delete();
            Log::info("Like removed");
        } else {
            $post->likes()->create(['user_id' => $user->id]);
            Log::info("Like added");
        }

        return response()->json([
            'liked' => !$like,
            'count' => $post->likes()->count(),
        ]);
    }
}
