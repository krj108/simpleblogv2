@extends('layouts.app')

@section('content')
<div class="container">
    <!-- نموذج البحث -->
    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <form method="GET" action="{{ route('posts.index') }}" class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search for posts..." value="{{ request()->input('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </form>
        </div>
    </div>

    <!-- فاصل -->
    <div class="row mb-4">
        <div class="col-12">
            <hr class="my-4">
        </div>
    </div>

    <!-- نص "أحدث المقالات" -->
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h2>Blogs</h2>
        </div>
    </div>

    <!-- عرض المقالات في شبكة ديناميكية -->
    <div class="row">
        @foreach ($posts as $post)
            <div class="col-md-4 mb-4"> <!-- 4 columns for medium screens -->
                <x-post-card :post="$post" />
            </div>
        @endforeach
    </div>

    <!-- روابط التصفح -->
    <div class="row">
        <div class="col-12">
            {{ $posts->links() }}
        </div>
    </div>
</div>
@endsection
