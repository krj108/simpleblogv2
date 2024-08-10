<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, $postId)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $comment = new Comment($request->all());
        $comment->post_id = $postId;
        $comment->user_id = Auth::id();
        $comment->is_approved = false; // تعيين التعليق كغير معتمد في البداية
        $comment->save();

        return redirect()->route('posts.show', $postId);
    }

    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $request->validate([
            'content' => 'required|string',
        ]);

        $comment->update($request->only('content'));

        return redirect()->route('posts.show', $comment->post_id);
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $postId = $comment->post_id;
        $comment->delete();
        return redirect()->route('posts.show', $postId);
    }

    public function toggleVisibility(Comment $comment)
    {
        $this->authorize('toggleVisibility', $comment);

        $comment->is_approved = !$comment->is_approved;
        $comment->save();

        return redirect()->route('posts.show', $comment->post_id);
    }
}




