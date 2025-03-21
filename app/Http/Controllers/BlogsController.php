<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Subscriber;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class BlogsController extends Controller
{
    public function blogs()
    {
        $search = request()->query('search');
        $categories = Category::all();
        $tags = Tag::all();
        if($search) {
            $posts = Post::with('author')
                ->where('title', 'like', "%{$search}%")
                ->latest()
                ->simplePaginate(9);
        } else {
            $posts = Post::with('author')
                ->latest()
                ->simplePaginate(9);
        }


        return view('frontend.home', compact([
            'posts',
            'categories',
            'tags'
        ]));
    }

    public function show(Request $request, String $slug)
    {
        $categories = Category::all();
        $tags = Tag::all();
        $post = Post::where('slug', $slug)->first();
        $comments = Comment::with('replies')->where('post_id', $post->id)->get()->toArray();
        $userName = User::where('id', $post->author_id)->firstOrFail()->name;


        $this->trackViewCount($post);
        return view('frontend.blog', compact([
            'post',
            'categories',
            'tags',
            'comments',
            'userName'
        ]));
    }

    private function trackViewCount(Post $post)
    {
        $cookieName = 'blog_viewed_' . $post->id;
        if (!Cookie::has($cookieName)) {
            $post->increment('view_count');

            Cookie::queue($cookieName, true, 60 * 24);
        }
    }

    public function showByCategory(Request $request, $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $categories = Category::all();
        $tags = Tag::all();

        $posts = Post::where('category_id', $category->id)->with('author')->latest()->simplePaginate(9);
        return view ('frontend.categories', compact([
            'category',
            'posts',
            'categories',
            'tags'
        ]));
    }

    public function showByTag(Request $request, $slug)
    {

        $tag = Tag::where('slug', '=', $slug)->firstOrFail();

        $categories = Category::all();
        $tags = Tag::all();

        $posts = $tag->posts()->latest()->simplePaginate(9);

        return view ('frontend.tags', compact([
            'tag',
            'posts',
            'categories',
            'tags'
        ]));
    }

    public function showUser(Request $request, User $user){

        $posts = Post::where('author_id', $user->id)->orderBy('view_count', 'desc');
        $famousPost = $posts->first();
        $posts = $posts->latest()->simplePaginate(9);
        $viewCount = $posts->sum('view_count');

        $categories = Category::all();
        $tags = Tag::all();

        return view('frontend.user', compact([
            'categories',
            'tags',
            'posts',
            'viewCount',
            'user',
            'famousPost'
        ]));
    }

    public function addSubscriber(Request $request){
        $validated = $request->validate([
            'email' => 'required|unique:subscribers|max:255'
        ]);
        Subscriber::create($validated);
        return redirect()->route('frontend.home')->with('success', 'Subscribed to newsletter successfully!');
    }
}
