@extends('layout.default')
@section('content')
    <div class="my-2 d-flex justify-content-between align-items-center">
        <h1>New article</h1>
    </div>
    <form action="{{ url('articles/store') }}" method="post">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" id="title" class="form-control">
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select name="category" id="category" class="form-select">
                <option value=""></option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="tags" class="form-label">Tags</label>
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
        <input type="submit" name="submit" class="btn btn-primary my-2" value="Submit">
    </form>
    <script src="https://cdn.tiny.cloud/1/w72ra0lqeonmlmaxdzp0gcs67xz4gibx09os91ed8axupn5q/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea',

            image_class_list: [{
                title: 'img-responsive',
                value: 'img-responsive'
            }, ],
            height: 500,
            setup: function(editor) {
                editor.on('init change', function() {
                    editor.save();
                });
            },
            plugins: [
                "advlist autolink lists link image charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste imagetools"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image ",

            image_title: true,
            automatic_uploads: true,
            relative_urls: false,
            remove_script_host: false,
            images_upload_url: '/api/images',
            file_picker_types: 'image',
            file_picker_callback: function(cb, value, meta) {
                var input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');
                input.onchange = function() {
                    var file = this.files[0];

                    var reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = function() {
                        var id = 'blobid' + (new Date()).getTime();
                        var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                        var base64 = reader.result.split(',')[1];
                        var blobInfo = blobCache.create(id, file, base64);
                        blobCache.add(blobInfo);
                        cb(blobInfo.blobUri(), {
                            title: file.name
                        });
                    };
                };
                input.click();
            }
        });
    </script>
@endsection
