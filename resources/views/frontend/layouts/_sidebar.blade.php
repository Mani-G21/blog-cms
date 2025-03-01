<div id="sidebar" class="col-md-3 mt50 animated" data-animation="fadeInRight" data-animation-delay="250">


    <!-- Search
    ===================================== -->
    <div class="pr25 pl25 clearfix">
        <form action="#">
            <div class="blog-sidebar-form-search">
                <input type="text" name="search" class="" placeholder="e.g. Javascript">
                <button type="submit" name="submit" class="pull-right"><i class="fa fa-search"></i></button>
            </div>
        </form>

    </div>


    <!-- Categories
    ===================================== -->
    <div class="mt25 pr25 pl25 clearfix">
        <h5 class="mt25">
            Categories
            <span class="heading-divider mt10"></span>
        </h5>
        <ul class="blog-sidebar pl25">
            @foreach ($categories as $category)
                <li><a href="{{ route('frontend.showByCategory', $category->slug) }}">{{ $category->name }}<span
                            class="badge badge-pasific pull-right">{{ $category->posts()->count() }}</span></a>
            @endforeach
        </ul>

    </div>


    <!-- Tags
    ===================================== -->
    <div class="pr25 pl25 clearfix">
        <h5 class="mt25">
            Popular Tags
            <span class="heading-divider mt10"></span>
        </h5>
        <ul class="tag">
            <li><a href="#">CS</a></li>
            <li><a href="#">Education</a></li>
            <li><a href="#">Coding</a></li>
            <li><a href="#">Engineering</a></li>
            <li><a href="#">Computers</a></li>
            <li><a href="#">Softwares</a></li>
            <li><a href="#">Programming</a></li>
        </ul>

    </div>
</div>
