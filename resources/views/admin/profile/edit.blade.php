@extends('admin.layouts.app')
@section('main-content')
    <div class="container rounded bg-white mt-5 mb-5">
        <div class="row">
            <div class="col-md-3 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                    <img class="rounded-circle mt-5" id="temp_image" width="150px" src=""><span
                        class="font-weight-bold">Profile Picture</span>
                    {{-- "https://ui-avatars.com/api/?name={$this->name}&rounded=true&bold=true"; --}}

                </div>

                <div class="row mb-3">
                    <div class="col-12">
                        <div class="form-group">
                            <div class="custom-file">
                                <input type="file" name="pic" id="pic" class="custom-file-input">
                                <label class="custom-file-label" for="pic">Choose file</label>
                            </div>
                        </div>

                        <small class="form-text text-danger pic_error"></small>
                    </div>
                </div>



            </div>
            <div class="col-md-5 border-right">
                <form action="" method="POST">
                    @csrf
                    <input type="text" class="form-control mt-2 d-none" placeholder="Upload Your Image" id="imageName"
                        name="profilePic" value="" disabled>
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Profile Settings</h4>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label class="labels">Name</label>
                                <input type="text" class="form-control" placeholder="first name"
                                    value={{ auth()->user()->name }} name="name">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12 mt-3"><label class="labels">Email ID</label>
                                <input type="text" class="form-control" placeholder="enter email id"
                                    value={{ auth()->user()->email }} name="email">
                            </div>
                            <div class="col-md-12 mt-3"><label class="labels">Education</label><input type="text"
                                    class="form-control" placeholder="education" value="" name="education"></div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6 mt-3"><label class="labels">Country</label><input type="text"
                                    class="form-control" placeholder="country" value="" name="country"></div>
                            <div class="col-md-6 mt-3"><label class="labels">State/Region</label><input type="text"
                                    class="form-control" value="" placeholder="state" name="state"></div>
                        </div>
                        <div class="mt-5 text-center"><button class="btn btn-primary profile-button" type="button">Save
                                Profile</button></div>
                    </div>
                </form>
            </div>
            <div class="col-md-4">
                <div class="p-3 py-5">

                    <div class="col-md-12"><label class="labels">Experience</label><input type="text"
                            class="form-control" placeholder="experience" value=""></div> <br>
                    <div class="col-md-12"><label class="labels">Bio</label>
                        <textarea type="text" class="form-control" placeholder="additional details" value=""></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
            });
        });
    </script>
@endsection
