@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2>{{ $post->title }}</h2>
                    <p>
                        <strong>Posted by:</strong> {{ $post->user->name }} - 
                        <strong>Posted on:</strong> {{ $post->created_at->format('d M Y, H:i') }} - 
                        <strong>Last updated:</strong> {{ $post->updated_at->format('d M Y, H:i') }}
                    </p>
                    @auth
                        @if ($post->user_id === Auth::id())
                            <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary float-right">Edit Post</a>
                        @endif
                    @endauth
                </div>
                <div class="card-body">
                    @if ($post->featured_image)
                        <img src="{{ asset('storage/' . $post->featured_image) }}" class="img-fluid mb-3" alt="{{ $post->title }}">
                    @endif
                    <p>{!! $post->content !!}</p> <!-- عرض المحتوى كـ HTML -->
                    <hr>
                    <h4>Comments</h4>

                    @foreach ($comments as $comment)
                        <x-comment-card :comment="$comment" />
                    @endforeach

                    @auth
                        <form method="POST" action="{{ route('comments.store', $post->id) }}">
                            @csrf
                            <div class="form-group">
                                <textarea name="content" id="content" class="form-control" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Comment</button>
                        </form>
                    @endauth

                    @guest
                        <div class="alert alert-info mt-4">
                            <strong>Comments are closed for non-registered users!</strong> To post a comment, please <a href="{{ route('login') }}" class="alert-link">login</a> or <a href="{{ route('register') }}" class="alert-link">register</a> if you don't have an account.
                        </div>
                    @endguest

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
