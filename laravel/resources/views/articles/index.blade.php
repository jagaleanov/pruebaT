@extends('layout.default')
@section('content')
    <div class="my-2 d-flex justify-content-between align-items-center">
        <h1>Blog</h1>
        <a href="{{ url('articles/create') }}" class="btn btn-primary">Nuevo artículo</a>
    </div>

    @foreach ($articles as $article)
        <div class="card mb-3">
            <h3 class="card-header">{{ $article->category->title }}</h3>
            <div class="card-body">
                <h2 class="card-title">{{ $article->title }}</h2>
                <div class="card-text">{!! $article->content !!}</div>
                <a href="{{ url('articles/show/' . $article->id) }}" class="btn btn-primary">Ver más</a>
            </div>
            <div class="card-footer text-body-secondary">
                @foreach ($article->tags as $tag)
                    <a href="#">{{ $tag->title }}</a>
                @endforeach
            </div>
        </div>
    @endforeach
@endsection
