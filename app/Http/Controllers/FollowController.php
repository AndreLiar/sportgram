<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    //
    public function toggle(User $user)
    {
        $authUser = Auth::user();

        if ($authUser->isFollowing($user)) {
            $authUser->following()->detach($user->id);
        } else {
            $authUser->following()->attach($user->id);
        }

        return back();
    }
}
