<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index(){
        $categories = Category::latest()->paginate(10);

        return view('admin.categories.index', compact([
            'categories'
        ]));
    }

    public function create(){
        $this->authorize('view', \App\Models\Category::class);
        return view('admin.categories.create');
    }

    public function store(Request $request){
        $validated = $request->validate([
            'name' => 'required|unique:categories|min:3|max:255'
        ]);
        Category::create($validated);
        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully!');
    }

    public function edit(Request $request, Category $category){
        $this->authorize('update', \App\Models\Category::class);
        return view('admin.categories.edit', compact([
            'category'
        ]));
    }

    public function update(Request $request, Category $category){
        $this->authorize('update', \App\Models\Category::class);
        $validated = $request->validate([
            'name' => 'required|min:3|max:255|unique:categories,name,'.$category->id
        ]);
        $category->update($validated);
        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category) {
        $this->authorize('update', \App\Models\Category::class);

        Post::where('category_id', $category->id)->each(function($post){
            $post->category_id = null;
            $post->save();
        });

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category Deleted Successfully!');
    }



}
