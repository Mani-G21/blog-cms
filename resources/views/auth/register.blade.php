@extends('layouts.app')

@section('content')
<div class="container rounded bg-white mt-5 mb-5 card">
    <div class="row">
                <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-3 border-right">
                            <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                                <img class="rounded-circle mt-5" id="temp_image" width="150px" src="https://ui-avatars.com/api/?name=NA&rounded=true&bold=true&color=ff1900" ><span
                                    class="font-weight-bold mt-3">Profile Picture</span>


                            </div>

                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="form-group">
                                        <div class="custom-file">
                                            <input type="file" name="profile_pic" id="pic" class="custom-file-input"
                                                accept="image/*" value="{{ old('pic') }}">
                                            <label class="custom-file-label" for="pic" style="color: #ff1900">Choose file</label>
                                        </div>
                                    </div>

                                    <small class="form-text text-danger pic_error"></small>
                                </div>
                            </div>



                        </div>
                        <div class="col-md-9">


                            <div class="p-3 py-5">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4 class="text-right" style="color: #ff1900">Register</h4>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <label class="labels">Name</label>
                                        <input id="name" type="text" class="form-control" placeholder="first name"
                                            value="{{ old('name') }}" name="name" required autocomplete="name" autofocus>
                                        @error('name')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12 mt-3"><label class="labels">Email ID</label>
                                        <input id="email" type="text" class="form-control" placeholder="enter email id"
                                            value="{{ old('email') }}" name="email">
                                        @error('email')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>



                                        <div class="col-md-12 mt-3"><label class="labels">Password</label>


                                                <input id="password" type="password" class="form-control md-12 @error('password') is-invalid @enderror" name="password" required>

                                            @error('password')
                                                <span class="text-danger text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>

                                <div class="col-md-12 mt-3"><label class="labels">Education/Qualification</label>
                                    <input type="text" class="form-control" placeholder="education"
                                        value="{{ old('education') }}" name="education">
                                </div>
                                @error('education')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror



                                    <div class="col-md-6 mt-3"><label class="labels">Country</label>
                                        <input type="text" class="form-control" placeholder="country"
                                            value="{{ old('country',) }}" name="country">
                                        @error('country')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>


                                    <div class="col-md-6 mt-3"><label class="labels">State/Region</label>
                                        <input type="text" class="form-control" value="{{ old('state') }}"
                                            placeholder="state" name="state">
                                        @error('state')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>


                                    <div class="col-md-12 mt-3">


                                           <label class="labels">Experience</label><input type="text"
                                                    class="form-control" placeholder="experience"
                                                    value="{{ old('experience') }}"
                                                    name="experience">
                                                @error('experience')
                                                    <span class="text-danger text-sm">{{ $message }}</span>
                                                @enderror
                                            <br>
                                           <label class="labels">Bio</label>
                                                <textarea type="text" class="form-control" placeholder="additional details" value="{{ old('bio') }}"
                                                    name="bio">{{ old('bio') }}</textarea>
                                                @error('bio')
                                                    <span class="text-danger text-sm">{{ $message }}</span>
                                                @enderror


                                    </div>

                                <div class="mt-5 text-center"><button class="col-md-2 p-2 btn btn-primary profile-button" type="submit" style="background-color: #ff1900">Register</button></div>
                            </div>

                </form>


    </div>
</div>
@endsection
@section('page-level-scripts')
<script>
    document.getElementById('pic').addEventListener('change', function(evt) {
        let selectedFile = evt.target.files[0];

        const fileReader = new FileReader();
        fileReader.readAsDataURL(selectedFile);
        fileReader.addEventListener('load', function(e) {
            document.getElementById('temp_image').src = e.target.result;
            document.getElementById('pic').src = e.target.result;
            console.log(document.getElementById('pic'));
        });


    });
</script>
@endsection
