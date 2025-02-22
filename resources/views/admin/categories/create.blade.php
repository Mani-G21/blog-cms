@extends('admin.layouts.app')
@section('title', 'Pen It - Categories Creation')

@section('main-content')
    <div class="card">
        <h1 class="card-header bg-white">
            Create new category
        </h1>
        <form action="{{ route('admin.categories.store')}}" method="POST">
            @csrf
            <div class="form-group p-3">
                <label for="name">Enter Category</label>
                <input type="name"
                       class="form-control @error('name')
                        is-invalid
                        @enderror" id="name"
                        value="{{old('name')}}"
                        placeholder="Category"
                        name="name"
                >
            </div>
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
            <div class="card-footer bg-white">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
@endsection
