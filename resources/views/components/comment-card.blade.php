@props(['comment'])

<div class="card mb-3">
    <div class="card-body">
        <p><span>{{ $comment->user->name }}</span>: {{ $comment->content }}</p>

        @can('update', $comment)
            <p class="text-muted">
                @if ($comment->is_approved)
                    <span class="badge badge-success">Visible</span>
                @else
                    <span class="badge badge-warning">Not Approved</span>
                @endif
            </p>
        @endcan

        @can('update', $comment)
            <form method="POST" action="{{ route('comments.update', $comment->id) }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <textarea name="content" class="form-control" rows="3" required>{{ $comment->content }}</textarea>
                </div>
                <button type="submit" class="btn btn-warning btn-custom">Update</button>
            </form>
        @endcan

        @can('delete', $comment)
            <form method="POST" action="{{ route('comments.destroy', $comment->id) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-custom">Delete</button>
            </form>
        @endcan

        @can('toggleVisibility', $comment)
            <form method="POST" action="{{ route('comments.toggleVisibility', $comment->id) }}">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-secondary btn-custom">
                    {{ $comment->is_approved ? 'Hide' : 'Show' }} Comment
                </button>
            </form>
        @endcan
    </div>
</div>
