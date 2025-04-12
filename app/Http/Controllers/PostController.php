<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\GeminiService;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $sport = $request->query('filter');
        $followingOnly = $request->query('following');

        $query = Post::with(['user', 'likes', 'comments.user'])
            ->when($sport, fn($query) => $query->where('sport', $sport))
            ->when($followingOnly && auth()->check(), function ($query) {
                $followingIds = auth()->user()->following()->pluck('users.id');
                $query->whereIn('user_id', $followingIds);
            })
            ->latest();

        $posts = $query->paginate(10);

        $availableSports = Post::select('sport')->distinct()->whereNotNull('sport')->pluck('sport');

        // ✅ Suggestions de sportifs à suivre
        $suggestions = User::where('id', '!=', auth()->id())
            ->whereDoesntHave('followers', fn ($q) => $q->where('follower_id', auth()->id()))
            ->inRandomOrder()
            ->take(5)
            ->get();

        return view('posts.index', compact('posts', 'sport', 'availableSports', 'followingOnly', 'suggestions'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request, GeminiService $gemini)
    {
        $request->validate([
            'sport' => 'nullable|string|max:100',
            'image' => 'required|image|max:2048',
            'caption' => 'nullable|string|max:255',
            'hashtags' => 'nullable|string|max:255',
        ]);

        $path = $request->file('image')->store('posts-temp', 'public');

        $userCaption = $request->input('caption');
        $userHashtags = $request->input('hashtags');

        $prompt = <<<EOT
Tu es une IA pour sportifs. Tu dois générer une version optimisée du texte suivant pour une publication sur un réseau social de sport.

Légende : "{$userCaption}"
Hashtags : "{$userHashtags}"

RÉPONDS UNIQUEMENT avec un JSON dans ce format :
{"caption": "ta légende ici", "hashtags": "tes hashtags ici"}
EOT;

        $ai = $gemini->generateFromText($prompt);

        return view('posts.review', [
            'imagePath' => $path,
            'userCaption' => $userCaption,
            'userHashtags' => $userHashtags,
            'caption' => $ai['caption'] ?? '',
            'hashtags' => $ai['hashtags'] ?? '',
            'sport' => $request->sport,
        ]);
    }

    public function finalize(Request $request)
    {
        $request->validate([
            'image_path' => 'required|string',
            'caption' => 'nullable|string|max:500',
            'hashtags' => 'nullable|string|max:255',
            'sport' => 'nullable|string|max:100',
        ]);

        Post::create([
            'user_id' => Auth::id(),
            'caption' => $request->caption,
            'hashtags' => $request->hashtags,
            'sport' => $request->sport,
            'image_path' => $request->image_path,
        ]);

        return redirect()->route('posts.index')->with('success', '📸 Publication validée et partagée avec succès !');
    }

    public function regenerateFromText(Request $request, GeminiService $gemini)
    {
        $request->validate([
            'caption' => 'nullable|string|max:255',
            'hashtags' => 'nullable|string|max:255',
        ]);

        $caption = $request->input('caption', '');
        $hashtags = $request->input('hashtags', '');

        $prompt = <<<EOT
Tu es une IA pour sportifs. Tu dois optimiser cette légende et ces hashtags pour une publication sur une plateforme sociale sportive.

Légende : "{$caption}"
Hashtags : "{$hashtags}"

Réponds en JSON uniquement : {"caption": "...", "hashtags": "..."}
EOT;

        $ai = $gemini->generateFromText($prompt);

        return response()->json([
            'caption' => $ai['caption'] ?? '',
            'hashtags' => $ai['hashtags'] ?? '',
        ]);
    }

    public function comment(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $comment = $post->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return response()->json([
            'success' => true,
            'user' => auth()->user()->name,
            'content' => $comment->content,
        ]);
    }
}
