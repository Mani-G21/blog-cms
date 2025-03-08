@extends('frontend.layouts.app')
@section('main-content')
    <div class="row">
        <div class="col-md-12">
            <h2>All Posts of Tag: <strong>{{ $tag->name }}</strong></h2>
        </div>
    </div>
    <div style="display: flex; flex-wrap:wrap;">
        @foreach ($posts as $post)

                <div style="width: 30%; margin-right: 3%; margin-bottom: 5dvh;">
                    <div class="text-wrap" style="height: 10%;">
                        <h4 class="blog-title"><a href={{ route('frontend.show', $post->slug) }}>{{ $post->title }}</a></h4>
                    </div>
                    <div class="blog-three-attrib">
                        <span class="icon-calendar"></span>Dec 15 2019 |
                        <span class=" icon-pencil"></span><a href="#">{{ $post->author->name }}</a>
                    </div>
                    <div style="height:50%">
                        <img style="width: 100%; height: 100%;" src="{{ asset($post->thumbnail_path) }}" alt="image blog">
                    </div>

                    @if (strlen($post->excerpt) > 20)
                        <p class="mt25">
                            {{ substr($post->excerpt, 0, 20) }}... <a href="{{ route('frontend.show', $post->slug) }}">read more</a>
                        </p>
                    @else
                        <p class="mt25">
                            {{ $post->excerpt }}
                        </p>
                    @endif

                    <a href={{ route('frontend.show', $post->slug) }} class="button button-gray button-xs">Read More <i
                            class="fa fa-long-arrow-right"></i></a>

                </div>

        @endforeach
    </div>

    {{ $posts->links('frontend.patials._pagination') }}

@endsection
