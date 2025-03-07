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
                                    <td>{{ ($post->category) ? $post->category->name : "" }}</td>
                                    <td>{{ implode(', ', $post->tags->pluck('name')->toArray()) }}</td>
                                    <td>
                                        @can('update', $post)
                                        <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-outline-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="btn btn-outline-danger delete-post" data-toggle="modal"
                                        data-target="#deleteModal" data-post-id="{{ $post->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    @endcan


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

    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteModalLabel">Delete Post ?</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you wanna delete this Post?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <form action="" method="POST" id="deleteForm">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete it!</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection



@section('page-level-scripts')
    <script>
        const deletePostsButtons = document.querySelectorAll('.delete-post');
        const deleteForm = document.querySelector("#deleteForm");
        function loadDeleteModal(evt) {
            let postId = null;
            if(evt.target.classList.contains('delete-post')) {
                postId = evt.target.dataset.postId;
            } else if(evt.target.parentElement.classList.contains('delete-post')) {
                postId = evt.target.parentElement.dataset.postId;
            }
            deleteForm.setAttribute('action', `/admin/posts/${postId}`);
        }

        deletePostsButtons.forEach(function(deletePostButton) {
            deletePostButton.addEventListener('click', loadDeleteModal);
        });
    </script>
@endsection

