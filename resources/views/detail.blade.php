@extends('layouts.app')
@section ('content')
    <div class="row">
        <div class="col-md-6 offset-4">
            <div class="post-content">
                @include('partials.imagepost')
            </div>
            <form action="/comments" method="post">
                {{ csrf_field() }}
                <input type="hidden" value="{{$post->public_id}}" name="post_id">
                <div class="input-group mb-1">
                    <input type="text" class="form-control" placeholder="Comment" aria-label="leave some comment"
                           aria-describedby="button-addon2" name="content">
                </div>
            </form>
            <div class="comment-section">
                @foreach($post->comments->reverse() as $comment)
                    <div class="comment-item">
                        <div class="comment-block">
                            <a href="/dashboard">{{ $comment->user->name }}</a>
                            {{ $comment->content }}
                        </div>

                        <div class="comment-footer">
                            <div class="footer-item">
                                <div class="time-block footer-block comment-time">
                                    <a href="#" class="time-color">{{ $comment->created_at->diffForHumans() }}</a>
                                </div>
                                <form action="/comments/upvote" method="post"
                                      class="footer-block react-block upvote-block">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="{{$comment->id}}" name="comment_id">
                                    <button
                                        class="btn btn-sm {{ $comment->currentReaction() == 'upvote' ? 'btn-success' : 'btn-default' }}"
                                        type="submit" name="upvote">{{ $comment->upvote }} <i
                                            class="fa fa-arrow-up"></i></button>
                                </form>
                            </div>
                            <div class="footer-item">
                                <form action="/comments/downvote" method="post" class="footer-block react-block">
                                    <input type="hidden" value="{{$comment->id}}" name="comment_id">
                                    {{ csrf_field() }}
                                    <button
                                        class="btn btn-sm {{ $comment->currentReaction() == 'downvote' ? 'btn-danger' : 'btn-default' }}"
                                        type="submit" name="downvote">{{ $comment->downvote }} <i
                                            class="fa fa-arrow-down"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="reply-block">
                        @foreach($comment->replies as $reply)
                            <div class="reply-item">
                                <a href="#">{{ $reply->user->name }}</a>
                                {{ $reply->content }}
                            </div>
                            <div class="time-block reply-time">
                                <a href="#" class="time-color">{{ $reply->created_at->diffForHumans() }}</a>
                            </div>
                            <div class="reply-react">
                                <form action="/replies/upvote" method="post"
                                      class="footer-block react-block upvote-block">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="{{$reply->id}}" name="reply_id">
                                    <button
                                        class="btn btn-sm {{ $reply->currentReaction() == 'upvote' ? 'btn-success' : 'btn-default' }}"
                                        type="submit" name="upvote">{{ $reply->upvote }} <i
                                            class="fa fa-arrow-up"></i></button>
                                </form>
                                <form action="/replies/downvote" method="post" class="footer-block react-block">
                                    <input type="hidden" value="{{$reply->id}}" name="reply_id">
                                    {{ csrf_field() }}
                                    <button
                                        class="btn btn-sm {{ $reply->currentReaction() == 'downvote' ? 'btn-danger' : 'btn-default' }}"
                                        type="submit" name="downvote">{{ $reply->downvote }} <i
                                            class="fa fa-arrow-down"></i></button>
                                </form>
                            </div>
                        @endforeach
                        <div class="reply-block">
                            <form class="form" method="post" action="/replies">
                                {{ csrf_field()}}
                                <input type="hidden" value="{{$comment->id}}" name="comment_id">
                                <div class="input-group col-sm-6">
{{--                                    <a href="#" value="{{ $user->name }}"></a>--}}
                                    <input type="text" class="form-control reply-control" id="reply-position" placeholder="Nhập phản hồi"
                                           aria-label="leave some comment"
                                           aria-describedby="button-addon2" name="content">
                                </div>
                            </form>
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
