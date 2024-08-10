<?php


namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    // يسمح بتعديل التعليق لصاحب التعليق أو صاحب المقال
    public function update(User $user, Comment $comment)
    {
        return $user->id === $comment->user_id || $user->id === $comment->post->user_id;
    }

    // يسمح بحذف التعليق لصاحب التعليق أو صاحب المقال
    public function delete(User $user, Comment $comment)
    {
        return $user->id === $comment->user_id || $user->id === $comment->post->user_id;
    }

    // يسمح لصاحب المقال فقط بتغيير حالة الظهور للتعليق
    public function toggleVisibility(User $user, Comment $comment)
    {
        return $user->id === $comment->post->user_id;
    }
}


