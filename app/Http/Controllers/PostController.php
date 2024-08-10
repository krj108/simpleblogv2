<?php

namespace App\Http\Controllers;
use Laravel\Scout\Searchable;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
        $this->middleware('can:update,post')->only(['edit', 'update', 'destroy']);
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
    
        if ($search) {
            $posts = Post::where('title', 'like', "%{$search}%")
                         ->orWhere('content', 'like', "%{$search}%")
                         ->latest()
                         ->paginate(10);
        } else {
            $posts = Post::latest()->paginate(10);
        }
    
        return view('posts.index', compact('posts'));
    }
    
    public function show(Post $post)
    {
        $comments = $post->comments()->with('user')->get();
    
        return view('posts.show', compact('post', 'comments'));
    }
    
    
    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'featured_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        $post = new Post($request->all());
        $post->user_id = Auth::id(); 
    
        if ($request->hasFile('featured_image')) {
            $imagePath = $request->file('featured_image')->store('featured_images', 'public');
            $post->featured_image = $imagePath;
        }
    
        $post->save();
    
        return redirect()->route('posts.index');
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post); // تأكد من أن المستخدم مخول بالتعديل
    
        return view('posts.edit', compact('post'));
    }
    

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'featured_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $post->title = $request->input('title');
        $post->content = $request->input('content');

        if ($request->hasFile('featured_image')) {
            // حذف الصورة القديمة إذا لزم الأمر
            if ($post->featured_image) {
                Storage::delete('public/' . $post->featured_image);
            }
            $imagePath = $request->file('featured_image')->store('featured_images', 'public');
            $post->featured_image = $imagePath;
        }

        $post->save();

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        return redirect()->route('posts.index');
    }

    
    
    
    
}

