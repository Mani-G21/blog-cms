<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::latest()->paginate(15);
        return view('admin.tags.index', compact([
            'tags'
        ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', \App\Models\Tag::class);
        return view('admin.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TagRequest $request)
    {
        Tag::create($request->validated());
        return redirect()->route('admin.tags.index')
            ->with('success', 'Tags Created Successfulyy');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        $this->authorize('update', \App\Models\Tag::class);
        return view('admin.tags.edit', compact([
            'tag'
        ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TagRequest $request, Tag $tag)
    {

        $tag->update($request->validated());
        return redirect()->route('admin.tags.index')->with('success', 'Tag Update Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        $tag->posts->each(function($post) use ($tag){
            $post->tags()->detach($tag);
            $post->save();
        });
        $tag->delete();

        return redirect()->route('admin.tags.index')->with('success', 'Tag Deleted Successfully!');
    }
}
