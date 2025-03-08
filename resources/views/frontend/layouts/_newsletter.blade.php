<div id="newsletter" class="bg-dark2 pt50 pb50">
    <div class="container">
        <div class="row">

            <div class="col-md-2">
                <h4 class="color-light">
                    Newsletter
                </h4>
            </div>

            <div class="col-md-10">
                <form name="newsletter" action={{route('subscribe')}} method="POST">
                    @csrf
                    <div class="input-newsletter-container">
                        <input type="email" name="email" class="input-newsletter" placeholder="enter your email address" required>
                    </div>

                    <button type="submit" class="button button-sm button-pasific hover-ripple-out">Subscribe<i
                            class="fa fa-envelope"></i></button>
                </form>
                @error('email')
                <span style="color: red">This email is already subscribed to the news letter!</span>
            @enderror
            </div>
        </div>
    </div>
</div>
