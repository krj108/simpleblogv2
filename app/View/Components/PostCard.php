<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Post;

class PostCard extends Component
{
    public $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function render()
    {
        return view('components.post-card');
    }
}

