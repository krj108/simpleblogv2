@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ isset($post) ? 'Edit Post' : 'Create Post' }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ isset($post) ? route('posts.update', $post->id) : route('posts.store') }}" enctype="multipart/form-data">
                        @csrf
                        @if(isset($post))
                            @method('PUT')
                        @endif
                        @if ($errors->any())

                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $post->title ?? '') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea id="content" name="content" class="form-control" rows="10">{{ old('content', $post->content ?? '') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="featured_image">Featured Image</label>
                            <input type="file" name="featured_image" id="featured_image" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">{{ isset($post) ? 'Update' : 'Create' }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Initialize Summernote -->
<script>
    $(document).ready(function() {
        $('#content').summernote({
            height: 300
        });
    });
</script>
@endsection
