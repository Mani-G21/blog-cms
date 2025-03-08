@extends('frontend.layouts.app')
@section('page-level-styles')
<style>
    .is-invalid+.select2>.selection>.select2-selection.select2-selection--multiple {
        border: solid 1px red;
    }

    .progress {
      height: 4.5px;
      width: 100%;
      background: linear-gradient(#ff4530 0 0),
        linear-gradient(#ff4530 0 0),
        #dbdcef;
      background-size: 60% 100%;
      background-repeat: no-repeat;
      animation: progress-7x9cg2 3s infinite;
    }

    @keyframes progress-7x9cg2 {
      0% {
        background-position: -150% 0, -150% 0;
      }

      66% {
        background-position: 250% 0, -150% 0;
      }

      100% {
        background-position: 250% 0, 250% 0;
      }
    }
</style>
@endsection
@section('main-content')
@include('admin.layouts._alerts')

    <div class="blog-three-mini">
        <h2 class="color-dark">
            <a href="#">{{ $post->title }}</a>
        </h2>
        <div class="blog-three-attrib">
            <div><i class="fa fa-calendar"></i></div>
            <?php
            $dt = new DateTimeImmutable($post->created_at);
            $createdAt = $dt->format('Y-m-d');
            ?>
            {{$createdAt}}
            <div><i class="fa fa-pencil"></i><a href={{route('frontend.showUser', $post->author_id)}}>{{$userName}}</a></div> |
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

            <form action="{{route('comment.store')}}" method="POST" id="commentForm">
                @csrf
                <input type="text" class="disabled invisible" name="on" value="" id="repliesTo">
                <input type="text" class="disabled invisible" name="postId" value={{$post->id}} id="postId">
                <input type="text" name="name" class="blog-leave-comment-input" placeholder="name" required id="sender">

                <textarea name="message" class="blog-leave-comment-textarea" id="commentBody" required>

                </textarea>

                <p class="invisible alert" style="color: red" id="inappropirateComment">This comment violates our terms and conditions! Please dont write inappropriate message*</p>
                <p class="invisible alert" style="color: red" id="emptyComment">Comment and name both are required!*</p>
                <div class="progress m-0 invisible" id="progressBar">
                    <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>


                <button class="button button-pasific button-sm center-block mb25" type="submit" id="leaveCommentButton">Leave Comment</button>
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
    <script>
        function validateCommentFromAI(evt) {
            evt.preventDefault();
            const loader = document.getElementById('progressBar');
            const inappropriateSpan = document.getElementById('inappropirateComment');
            const emptySpan = document.getElementById('emptyComment');
            const sender = document.getElementById('sender');

            inappropriateSpan.classList.add('invisible');
            loader.classList.remove('invisible');
            emptySpan.classList.add('invisible');
            const comment = document.getElementById('commentBody').value.trim();

            if (!comment || !sender.value) {
                emptySpan.classList.remove('invisible');
                loader.classList.add('invisible');
                return;
            }

            fetch(`/api/comment/validate-ai`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ comment })
            })
            .then(res => res.json())
            .then(data => {
                loader.classList.add('invisible');
                if (data.content == "TRUE\n") {
                    document.getElementById("commentForm").submit();
                } else {
                    console.log(inappropriateSpan);
                    inappropriateSpan.classList.remove('invisible');
                }
            })
            .catch(err => console.log("Error:", err));
        }


        document.getElementById('leaveCommentButton').addEventListener('click', validateCommentFromAI);
        </script>

@endsection
