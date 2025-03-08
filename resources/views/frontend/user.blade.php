@extends('frontend.layouts.app')
@section('main-content')
<section class="section about-section gray-bg" id="about">

    <div class="card">
        <div class="container">
            <div class="row align-items-center flex-row-reverse">
                <div class="col-lg-6">
                    <div class="about-text go-to">
                        <h2 class="dark-color">{{$user->name}}</h2>
                        <h6 class="theme-color lead">{{$user->education}}</h6>
                        <p>{{$user->bio}}</p>
                        <div class="row about-list">
                            <div class="col-md-6">


                                <div class="media">
                                    <label>Residence</label>
                                    <p>{{$user->country}}</p>
                                </div>
                                <div class="media">
                                    <label>State</label>
                                    <p>{{$user->state}}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="media">
                                    <label>E-mail</label>
                                    <p>{{$user->email}}</p>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                        <img class="rounded-circle mt-5" id="temp_image" width="150px"
                        src="{{ asset($user->user_profile) }}">
                </div>
            </div>

            <div style="width: 50dvw">
                <div class="row">
                    <div class="col-lg-2">
                        <div class="count-data text-center">
                            <h6 class="count h2">{{$posts->count()}}</h6>
                            <p class="m-0px font-w-600">Total blogs</p>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="count-data text-center">
                            <h6 class="count h2">{{$viewCount}}</h6>
                            <p class="m-0px font-w-600">Total views on posts</p>
                        </div>
                    </div>



                    <div class="col-lg-4">
                        <div class="count-data text-center">
                            <h6 class="count h2">
                                @foreach ($posts->first()->tags as $tag)
                                <span>{{   $tag->name." " }}</span>
                                @endforeach
                            </h6>
                            <p class="m-0px font-w-600">is / are {{$user->name}}'s most famous tags</p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="count-data text-center">
                            <h6 class="count h2">{{$posts->first()->category->name}}</h6>
                            <p class="m-0px font-w-600">is {{$user->name}}'s most famous category</p>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

   <div class="card">
    <div class="card-header">
        <h2>Most Famous Blog Of {{$user->name}}</h2>
        <div style="display: flex; flex-wrap:wrap;">


            <div style="width: 30%; margin-right: 3%; margin-bottom: 5dvh;">
                <div class="text-wrap" style="height: 10%;">
                    <h4 class="blog-title"><a href={{ route('frontend.show', $famousPost->slug) }}>{{ $famousPost->title }}</a></h4>
                </div>
                <div class="blog-three-attrib">
                    <span class="icon-calendar"></span>
                    <?php
                    $dt = new DateTimeImmutable($famousPost->created_at);
                    $createdAt = $dt->format('Y-m-d');
                    ?>
                    {{$createdAt}}

                </div>
                <div style="height:50%">
                    <img style="width: 100%; height: 100%;" src="{{ asset($famousPost->thumbnail_path) }}" alt="image blog">
                </div>

                @if (strlen($famousPost->excerpt) > 20)
                    <p class="mt25">
                        {{ substr($famousPost->excerpt, 0, 20) }}... <a href="{{ route('frontend.show', $famousPost->slug) }}">read more</a>
                    </p>
                @else
                    <p class="mt25">
                        {{ $famousPost->excerpt }}
                    </p>
                @endif

                <a href={{ route('frontend.show', $famousPost->slug) }} class="button button-gray button-xs">Read More <i
                        class="fa fa-long-arrow-right"></i></a>

            </div>


    </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2>All Blogs Of {{$user->name}}</h2>
            <div style="display: flex; flex-wrap:wrap;">
                @foreach ($posts as $post)

                        <div style="width: 30%; margin-right: 3%; margin-bottom: 5dvh;">
                            <div class="text-wrap" style="height: 10%;">
                                <h4 class="blog-title"><a href={{ route('frontend.show', $post->slug) }}>{{ $post->title }}</a></h4>
                            </div>
                            <div class="blog-three-attrib">
                                <span class="icon-calendar"></span>
                                <?php
                                $dt = new DateTimeImmutable($post->created_at);
                                $createdAt = $dt->format('Y-m-d');
                                ?>
                                {{$createdAt}}

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
        </div>

</section>
{{ $posts->links('frontend.patials._pagination') }}
@endsection
