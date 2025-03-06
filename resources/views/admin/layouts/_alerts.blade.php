@if(session()->has('success'))
    <div style="background-color: rgb(140, 235, 140); padding:10px; border: 1px solid green; border-radius: 10px">
        {{ session('success') }}
    </div>
@endif

@if(session()->has('error'))
    <div class="alert alert-danger fade show">
        {{ session('error') }}
    </div>
@endif
