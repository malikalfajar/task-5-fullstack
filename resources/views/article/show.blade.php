@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-8">
            <!-- Post content-->
            <article>
                <!-- Post header-->
                <header class="mb-4 ">
                    <!-- Post title-->

                    <h1 class="fw-bolder mb-1">{{ $article->title}}</h1>
                    <!-- Post meta content-->

                    <!-- Post categories-->
                    <span class="badge bg-secondary text-decoration-none link-light">{{ $article->category->name }}</span>


                </header>
                <!-- Preview image figure-->

                <figure class="mb-4"><img class="img-fluid rounded" src="{{ asset('/storage/'.$article->image) }}" alt="..." /></figure>
                <!-- Post content-->
                <section class="mb-5">
                    {{ $article->content }}
                </section>
            </article>
            <!-- Comments section-->

        </div>
        <!-- Side widgets-->

        <div class="col-lg-4">
            <!-- Search widget-->

            <!-- Categories widget-->

            <!-- Side widget-->
            <div class="card mb-4">
                <div class="card-header">Information</div>
                <div class="card-body">
                    <div class="text-muted fst-italic mb-2">Posted on {{ $article->created_at }}</div>
                    <div class="text-muted fst-italic mb-2">Updated At {{ $article->updated_at }}</div>
                    <div class="text-muted fst-italic mb-2">Author {{ $article->user->name }}</div>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">Option</div>
                <div class="card-body">
                    <div class="input-group justify-content-end gap-4">
                        @can('delete', $article)
                        <form action="{{ route('articles.destroy', ['article' => $article]) }}" method="POST">
                            @method('Delete')
                            @csrf

                            <button class="btn btn-danger btn-sm">
                                Delete
                            </button>
                        </form>
                        @endcan

                        @can('update', $article)
                        <a class="btn btn-warning btn-sm" href="{{ route('articles.edit', ['article' => $article]) }}">
                            Edit
                        </a>
                        @endcan
                        <a class="btn btn-primary text-white btn-sm" href="{{ url('/') }}">
                            Back
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


@endsection