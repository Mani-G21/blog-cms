@extends('frontend.layouts.app')
@section('main-content')
    <div class="blog-three-mini">
        <h2 class="color-dark">
            <a href="#">{{ $post->title }}</a>
        </h2>
        <div class="blog-three-attrib">
            <div><i class="fa fa-calendar"></i>Dec 15 2015</div> |
            <div><i class="fa fa-pencil"></i><a href="#">Harry Boo</a></div> |
            <div><i class="fa fa-comment-o"></i><a href="#">90 Comments</a></div> |
            <div><a href="#"><i class="fa fa-thumbs-o-up"></i></a>150 Likes</div> |
            <div>
                Share: <a href="#"><i class="fa fa-facebook-official"></i></a>
                <a href="#"><i class="fa fa-twitter"></i></a>
                <a href="#"><i class="fa fa-linkedin"></i></a>
                <a href="#"><i class="fa fa-google-plus"></i></a>
                <a href="#"><i class="fa fa-pinterest"></i></a>
            </div>
        </div>

        <img src="{{ asset($post->thumbnail_path) }}" alt="Blog Image" class="img-responsive">
        {!! $post->body !!}
        <div class="blog-post-read-tag mt50">
            <i class="fa fa-tags"></i> Tags:
            @foreach ($post->tags as $tag)
                <a href="#"> {{ $tag->name }}</a>,
            @endforeach
        </div>

    </div>
    <div class="blog-post-comment-container">
        <h5><i class="fa fa-comments-o mb25"></i> {{" ".count($comments)." Comments"}}</h5>


        @foreach ($comments as $comment)
            <div class='blog-post-comment'>
                <img src="https://ui-avatars.com/api/?name={{$comment['sender']}}&rounded=true&bold=true" class="img-circle"
                    alt="image" height="40px">
                <span class="blog-post-comment-name">{{$comment['sender']}}</span>
                <?php
                $dt = new DateTimeImmutable($comment['created_at']);
                $commentDate = $dt->format('Y-m-d');
                ?>
                <span class="blog-post-comment-date">{{$commentDate}}</span>
                <a href="#leaveComment"
                    data-refers-to="{{$comment['id']}}"
                    class="pull-right text-gray reply"><i class="fa fa-comment"></i> Reply
                </a>
                <p style="margin-left: 6rem">
                    {{ $comment['content'] }}
                </p>
            </div>
            @if (count($comment['replies']) > 0)
                @foreach ($comment['replies'] as $reply)
                    <div class='blog-post-comment-reply' style="border: none">
                        <img src="https://ui-avatars.com/api/?name={{$reply['sender']}}&rounded=true&bold=true" class="img-circle"
                            alt="image" height="40px" style="margin-right: 1.5rem; ">

                            <?php
                            $dt = new DateTimeImmutable($reply['created_at']);
                            $replyDate = $dt->format('Y-m-d');
                            ?>

                            <span class="blog-post-comment-name">{{$reply['sender']}}</span>
                            <span class="blog-post-comment-date">{{$replyDate}}</span>

                        <p style="margin-left: 6rem">
                            {{ $reply['content'] }}
                        </p>
                    </div>
                @endforeach


            @endif
        @endforeach

        {{-- {{ $comments->links('frontend.patials._pagination') }} --}}

        <div class="blog-post-leave-comment" id="leaveComment">
            <h5><i class="fa fa-comment mt25 mb25"></i> Leave Comment</h5>

            <form action="{{route('comment.store')}}" method="POST">
                @csrf
                <input type="text" class="disabled invisible" name="on" value="" id="repliesTo">
                <input type="text" class="disabled invisible" name="postId" value={{$post->id}} id="postId">
                <input type="text" name="name" class="blog-leave-comment-input" placeholder="name" required>
                <textarea name="message" class="blog-leave-comment-textarea"></textarea>
                <button class="button button-pasific button-sm center-block mb25" type="submit">Leave Comment</button>
            </form>

        </div>

    </div>
@endsection
@section('page-level-scripts')
    <script>
        const replyLinks = (document.querySelectorAll('.reply'));
        replyLinks.forEach(replyLink => {
            replyLink.addEventListener('click', function(e){

                document.getElementById('repliesTo').value = e.target.dataset.refersTo;
            })
        });
    </script>
@endsection
