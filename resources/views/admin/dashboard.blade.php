@extends('admin.layouts.app')

@section('main-content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> --}}
    </div>
    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total posts</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $posts->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-list-ol fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total views on posts</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $viewCount }}</div>
                        </div>
                        <div class="col-auto">

                            <i class="bi bi-eye-fill fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Current Subscribed Plan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $planName }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Remaining AI requests</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $articlesRemaining }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-robot fa-2x text-gray-300"></i>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Most engaging category</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @if ($posts->count() != 0)
                                    {{ $posts->first()->category->name }}
                                @else
                                    <p>None</p>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Most engaging tags</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @if ($posts->count() != 0)
                                    @foreach ($posts->first()->tags as $tag)
                                        <span>{{   $tag->name." " }}</span>
                                    @endforeach
                                @else
                                    <p>None</p>
                                @endif

                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="row">

        <!-- Content Column -->
        <div class="col-lg-12 mb-4">

            <!-- Project Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Post wise views</h6>
                </div>
                <div class="card-body">
                    @foreach ($posts as $post)
                        <h4 class="small font-weight-bold">{{ $post->title }}<span
                                class="float-right">{{ $post->view_count }} / {{ $viewCount }}</span></h4>
                        <div class="progress mb-4">
                            <div class="progress-bar bg-danger" role="progressbar"
                            style="{{ $viewCount != 0 ? 'width:' . ($post->view_count / $viewCount) * 100 . '%' : 'width:0%' }}"
                            aria-valuenow="20"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    @endforeach
                </div>
            </div>


        </div>

    </div>

    <!-- Content Row -->

    <!-- Content Row -->
@endsection

@section('page-level-scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('admin/vendor/chart.js/Chart.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('admin/js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('admin/js/demo/chart-pie-demo.js') }}"></script>
@endsection
