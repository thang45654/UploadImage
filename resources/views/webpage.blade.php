@extends('layouts.app')
@section ('content')
    <div class="col-md-4 offset-4">
        <div class="post-content">
                @foreach($posts->reverse() as $post)
                    @include('partials.imagepost')
                @endforeach
        </div>
    </div>
@endsection
