<div class="card shadow-sm h-100">
    @if ($post->featured_image)
        <img src="{{ asset('storage/' . $post->featured_image) }}" class="card-img-top" alt="{{ $post->title }}">
    @endif
    <div class="card-body text-center">
        <h5 class="card-title"><a href="{{ route('posts.show', $post->id) }}" class="text-dark">{{ $post->title }}</a></h5>
        <a href="{{ route('posts.show', $post->id) }}" class="btn btn-primary btn-sm">Read more</a>
    </div>
</div>
