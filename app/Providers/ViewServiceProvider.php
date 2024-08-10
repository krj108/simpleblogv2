<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // تمرير أحدث 5 مقالات إلى جميع العروض التي تستخدم layout.app
        View::composer('layouts.app', function ($view) {
            $view->with('recentPosts', Post::latest()->take(5)->get());
        });

        // تمرير التعليقات ومتغير canEdit إلى العروض التي تستخدم posts.show
        View::composer('posts.show', function ($view) {
            $post = $view->post;
            $comments = $post->comments()->with('user')->get();

            $comments->each(function($comment) use ($post) {
                $comment->canEdit = Auth::id() === $comment->user_id || Auth::id() === $post->user_id;
            });

            $view->with('comments', $comments);
        });
    }
}

