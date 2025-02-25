@extends('admin.layouts.app')
@section('title', 'Pen It - User updation')

@section('main-content')
    <div class="card">
        <h1 class="card-header bg-white">
            Edit User
        </h1>

        <form action="{{ route('admin.users.update', $user)}}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group p-3">
                <label for="name">Enter user name</label>
                <input type="name"
                       class="form-control @error('name')
                        is-invalid
                        @enderror" id="name"
                        value="{{old('name', $user->name)}}"
                        placeholder="User"
                        name="name"
                >
            </div>
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror

            <div class="form-group p-3">
                <label for="name">Enter email</label>
                <input type="name"
                       class="form-control @error('name')
                        is-invalid
                        @enderror" id="name"
                        value="{{old('email', $user->email)}}"
                        placeholder="email"
                        name="email"
                >
            </div>
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror

            <div class="card-footer bg-white">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
@endsection
