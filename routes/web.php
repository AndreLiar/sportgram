<?php
//   routes/web.php
// Importation des contrôleurs nécessaires
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PublicProfileController;

// Route de la page d'accueil (publique)
Route::get('/', function () {
    return view('welcome');
});

// Route du dashboard (nécessite d'être authentifié et vérifié)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Groupe de routes protégées (requiert l'utilisateur connecté)
Route::middleware('auth')->group(function () {

    // Profil de l'utilisateur (édition, mise à jour, suppression)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Affichage du profil public d’un utilisateur
    Route::get('/users/{user}', function (\App\Models\User $user) {
        return view('profile.show', compact('user'));
    })->middleware('auth')->name('profile.show');


Route::get('/users/{user}', [PublicProfileController::class, 'show'])
->middleware('auth')
->name('profile.show');

    // Fil d’actualité (affichage des posts)
    Route::get('/feed', [PostController::class, 'index'])->name('posts.index');

    // Formulaire de création de post
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');

    // Enregistrement temporaire + génération IA (upload image)
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

    // Finalisation de la publication (avec légende IA validée)
    Route::post('/posts/finalize', [PostController::class, 'finalize'])->name('posts.finalize');

    // Re-génération IA du contenu (légende + hashtags)
    Route::post('/posts/regenerate-text', [PostController::class, 'regenerateFromText'])
        ->name('posts.regenerateText')
        ->middleware('auth');

    // Action AJAX : liker ou unliker un post
    Route::post('/posts/{post}/like', [LikeController::class, 'toggle'])->name('posts.like');

    // Action AJAX : commenter un post
    Route::post('/posts/{post}/comments', [PostController::class, 'comment'])->name('posts.comments');

    // Système de follow/unfollow entre utilisateurs
    Route::middleware('auth')->group(function () {
        Route::post('/users/{user}/follow', [\App\Http\Controllers\FollowController::class, 'toggle'])->name('users.follow');
    });
});

// Inclusion des routes d'authentification Laravel Breeze/Fortify/etc.
require __DIR__.'/auth.php';
