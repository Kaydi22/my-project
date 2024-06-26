<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine wheter the user can delete the model.
     * 
     * @param  \App\Models\User $user
     * @param  \App\Models\Post $post
     * @return \Illuminate\Auth\Access\Response|bool
     */

    public function delete(User $user, Post $post)
    {
        return $user->id === $post->user_id;
    }
}
