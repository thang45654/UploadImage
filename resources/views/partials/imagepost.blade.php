<div class="card post">
    <div class="card-header">
        <a href="/posts/{{ $post->public_id }}">
            <h4>{{ $post->title }}</h4>
        </a>
        <span id="font">
              Đăng bởi
        <a href="#">
            <b>{{ $post->user->name }} </b>
        </a>
        <a href="#" class="time">
            {{ $post->created_at->diffForHumans() }}
        </a>
        </span>
    </div>
    <div class="card-body">
        <img class="post-body-image" src="{{$post->image }}"/>
    </div>
    <div class="card-footer text-muted">
        <div class="post-footer">
            <div class="footer-item">
                <form action="/posts/upvote" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" value="{{$post->public_id}}" name="post_id">
                    <span class="footer-item">
                <button class="btn {{ $post->currentReaction() == 'upvote' ? 'btn-success' : 'btn-default' }}"
                        type="submit" name="upvote">{{ $post->upvote }}
                    <i class="fa fa-thumbs-up"></i></button>
            </span>
                </form>
            </div>
            <div class="footer-item">
                <form action="/posts/downvote" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" value="{{$post->public_id}}" name="post_id">
                    <span class="footer-item">
                <button type="submit"
                        class="btn {{ $post->currentReaction() == 'downvote' ? 'btn-danger' : 'btn-default' }}"
                        name="downvote">{{ $post->downvote }}
                    <i class="fa fa-thumbs-down"></i></button>
            </span>
                    <span class="footer-item">
            </span>
                </form>
            </div>
            <div class="footer-item">
                <button class="btn btn-default"><a href="/posts/{{ $post->public_id }}">
                        {{$post->comments->count()}} <i class="fa fa-comment"></i>
                    </a>
                </button>
            </div>
        </div>
    </div>
</div>
