@extends('admin.layouts.app')

@section('main-content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Users</h1>
    </div>

    @include('admin.layouts._alerts')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-striped table-responsive">
                        <thead>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </thead>

                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>

                                    <td>
                                        <img src="{{ asset($user->user_profile) }}" class="img-circle" alt="image" height="40px">
                                        {{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role }}</td>

                                    <td>
                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="btn btn-outline-danger delete-user" data-toggle="modal"
                                            data-target="#deleteModal" data-user-id="{{ $user->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{ $users->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

        <!-- Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="deleteModalLabel">Delete User ?</h1>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you wanna delete this user? All the posts made by this user will also be removed!</p>
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
        const deleteUsersButtons = document.querySelectorAll('.delete-user');
        const deleteForm = document.querySelector("#deleteForm");
        function loadDeleteModal(evt) {
            let userId = null;
            if(evt.target.classList.contains('delete-user')) {
                userId = evt.target.dataset.userId;
            } else if(evt.target.parentElement.classList.contains('delete-user')) {
                userId = evt.target.parentElement.dataset.userId;
            }
            deleteForm.setAttribute('action', `/admin/users/${userId}`);
        }

        deleteUsersButtons.forEach(function(deleteUserButton) {
            deleteUserButton.addEventListener('click', loadDeleteModal);
        });
    </script>
@endsection


