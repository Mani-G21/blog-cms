<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::with('category')->with('tags')->latest()->paginate(20);
        return view('admin.posts.index', compact([
            'posts'
        ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.create', compact([
            'categories',
            'tags'
        ]));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePostRequest $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();
            if ($request->hasFile('thumbnail')) {
                $filePath = $request->file('thumbnail')->store('thumbnails', 'public');
                $data['thumbnail'] = $filePath;
            }
            $data['author_id'] = auth()->id();
            $post = Post::create($data);
            $post->tags()->attach($request->tags);

            DB::commit();
            return redirect()->route('admin.posts.index')
                ->with('success', 'Post created successfully!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            return redirect()->route('admin.posts.index')
                ->with('error', 'Some internal server issue!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.edit', compact([
            'post',
            'categories',
            'tags'
        ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $data = $request->validated();
        if ($request->hasFile('thumbnail')) {
            Storage::disk('public')->delete($post->thumbnail);
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }
        $post->update($data);
        $post->tags()->sync($request->tags);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        DB::beginTransaction();
        try{
            $post->tags()->detach(
                $post->tags
            );

                $post->delete();
                Storage::disk('public')->delete($post->thumbnail);
                DB::commit();
                return redirect()->route('admin.posts.index')->with('success', 'Post deleted Successfully');

        }catch(Exception $ex){
            DB::rollBack();
            return redirect()->route('admin.posts.index')->with('error', 'Some internal server error occured!');
        }
    }
}
