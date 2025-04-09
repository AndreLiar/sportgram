<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\Services\GeminiService;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $sport = $request->query('filter');

        $posts = Post::with('user')
            ->when($sport, fn($query) => $query->where('sport', $sport))
            ->latest()
            ->paginate(10);

        $availableSports = Post::select('sport')
            ->distinct()
            ->whereNotNull('sport')
            ->pluck('sport');

        return view('posts.index', compact('posts', 'sport', 'availableSports'));
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
    


}
