@extends('admin.layouts.app')

@section('main-content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Posts</h1>
        <a href="{{ route('admin.posts.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-cog fa-sm text-white-50"></i> Create Post</a>
    </div>

    @include('admin.layouts._alerts')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-striped table-responsive">
                        <thead>
                            <th>ID</th>
                            <th>Thumbnail</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Tags</th>
                            <th>Actions</th>
                        </thead>

                        <tbody>
                            @foreach($posts as $post)
                                <tr>
                                    <td>{{ $post->id }}</td>
                                    <td width="20%">
                                        <img src="{{env('APP_URL')}}/storage/{{ $post->thumbnail }}" alt="{{ $post->title }}" class="img-fluid">
                                    </td>
                                    <td>{{ $post->title }}</td>
                                    <td>{{ $post->category->name }}</td>
                                    <td>{{ implode(', ', $post->tags->pluck('name')->toArray()) }}</td>
                                    <td>
                                        <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-outline-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{ $posts->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
