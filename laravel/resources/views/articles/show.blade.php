@extends('layout.default')
@section('content')
    <div class="my-2 d-flex justify-content-between align-items-center">
        <h1>{{ $article->title }}</h1>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            Etiquetas:
            @foreach ($article->tags as $tag)
                <a href="#">{{ $tag->title }}</a>
            @endforeach
            <p class="card-text">{!! $article->content !!}</p>
        </div>
        <div class="card-footer text-body-secondary">
            <h2 class="card-title">Comentarios</h2>
            @foreach ($article->comments as $comment)
                <div class="card mb-3">
                    <div class="card-body">
                        <p class="card-title">{{ $comment->user->name }}</p>
                        <p class="card-title">{{ $comment->created_at }}</p>
                        <div class="card-text">{!! $comment->content !!}</div>
                    </div>
                </div>
            @endforeach

            <form action="{{ url('comments/store') }}" method="post">
                @csrf
            <h3 class="card-title">Deja tu comentario</h3>

                <div class="mt-1">
                    <textarea id="textArea" name="content" class="form-control"></textarea>
                </div>
                <input type="hidden" name="article_id" value="{{$article->id}}">
                <input type="submit" name="submit" class="btn btn-primary my-2" value="Guardar">
            </form>

        </div>
    </div>
    <script src="https://cdn.tiny.cloud/1/w72ra0lqeonmlmaxdzp0gcs67xz4gibx09os91ed8axupn5q/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#textArea',
        });
    </script>
@endsection
