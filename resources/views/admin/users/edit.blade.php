@extends('admin.layouts.app')
@section('title', 'Pen It - User updation')

@section('main-content')
    <div class="card">
        <h1 class="card-header bg-white">
            Edit {{$user->name . "'s role"}}
        </h1>

        <form action="{{ route('admin.users.update', $user)}}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group p-3">
                <label for="name">Enter Role of this user</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <label class="input-group-text" for="inputGroupSelect01">Roles</label>
                    </div>
                    <select class="custom-select" id="inputGroupSelect01" name="role">
                      <option selected disabled>Choose...</option>
                      <option value="author">Author</option>
                      <option value="admin">Admin</option>
                    </select>
                  </div>
            </div>
            @error('role')
                <small class="text-danger">{{ $message }}</small>
            @enderror

            <div class="card-footer bg-white">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
@endsection
