@extends('layout.default')
@section('content')
{{ url('/') }}
    <div class="my-2 d-flex justify-content-between align-items-center">
        <h1>Nuevo artículo</h1>
    </div>
    <form action="{{ url('articles/store')}}" method="post">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Título</label>
            <input type="text" name="title" id="title" class="form-control">
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Categoría</label>
            <select name="category" id="category" class="form-select">
                <option value=""></option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="tags" class="form-label">Etiquetas</label>
            {{-- <select multiple name="tags" id="tags" class="form-select">
                @foreach ($tags as $tag)
                <option value="{{$tag->id}}">{{$tag->title}}</option>
                @endforeach
            </select> --}}

            @foreach ($tags as $tag)
                <div class="form-check">
                    <input type="checkbox" name="tags[]" id="tags[]" class="form-check-input"
                        value="{{ $tag->id }}">
                    <label class="form-check-label" for="tags[]">
                        {{ $tag->title }}
                    </label>
                </div>
            @endforeach
        </div>

        <div class="mt-1">
            <textarea id="textArea" name="content" class="form-control"></textarea>
        </div>
        <input type="submit" name="submit" class="btn btn-primary my-2" value="Guardar">
    </form>
    <script src="https://cdn.tiny.cloud/1/w72ra0lqeonmlmaxdzp0gcs67xz4gibx09os91ed8axupn5q/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#textArea',
            plugins: 'image imagetools',
            toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            images_upload_url: '/api/images',
            automatic_uploads: true,
        });
    </script>
@endsection
