<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;

class PublicProfileController extends Controller
{
    //
    public function show(User $user)
    {
        // Chargement optimisé (posts, followers, following)
        $user->load('posts', 'followers', 'following');

        return view('profile.show', compact('user'));
    }
}
