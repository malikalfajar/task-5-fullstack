@extends('layouts.app')

@section('content')


<div class="row justify-content-center mb-4">
    <div class="col-md-8 d-flex justify-content-end gap-4">
        @can('create', App\Models\Article::class)
        <a href="{{ route('articles.create') }}" class="btn btn-primary">Add Article</a>
        @endcan
        <a href="{{ route('categories.index') }}" class="btn btn-outline-primary">Categories</a>
    </div>
</div>
<header class="">
    <div class="container text-center">
        <div class="navbar-header">
            <h1 class="fw-bolder mb-1 ">
                <a href="./">Articles<br>

                </a>
            </h1>
        </div>
    </div>
</header>

</div>
<div class="container">
    <div class="row">
        @foreach ($articles as $key => $article)
        <div class="col-xs-12 col-sm-4">
            <div class=" card">
                <img src="{{ asset('/storage/'.$article->image) }}" alt="{{ $article->image }}" height="300px" width="150px" class="card-img-top" />
                <div class="card-body">
                    <h5 class="card-title">{{ $article->title }}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{ $article->category->name }}</h6>
                    <p class="card-text">
                        {{ $article->content }}
                    </p>
                    <a href="{{ route('articles.show', ['article' => $article]) }}" class="btn btn-primary float-end">Read More</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-6">
        {{ $articles->links() }}
    </div>
</div>
</div>


@endsection