@extends('layouts.app')
@section ('content')
    <div class="row">
        <div class="col-md-6 offset-4">
            <form class="form" action="{{ url('/posts') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <label>Title</label>
                    <input class="form-control" placeholder="Nhập tiêu đề của ảnh" name="title"></input>
                </div>
                <div class="form-group">
                    <label for="select">Chọn ảnh</label>
                    <input class="form-control-file" type="file" id="select" value="Upload image" name="image"
                           accept="image/*">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Tải ảnh lên</button>
                </div>
            </form>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="post-content">
                @foreach($posts->reverse() as $post)
                    @include('partials.imagepost')
                @endforeach

            </div>
        </div>
    </div>
@endsection
