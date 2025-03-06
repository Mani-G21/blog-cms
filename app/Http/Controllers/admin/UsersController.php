<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Post;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->role === 'admin') {
            $users = User::latest()->paginate(25);
            return view('admin.users.index', compact([
                'users'
            ]));
        } else {
            abort(403, "THIS ACTION IS UNAUTHORIZED");
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        if (auth()->user()->role === 'admin') {
            return view('admin.users.edit', compact([
                'user',
            ]));
        } else {
            abort(403, "THIS ACTION IS UNAUTHORIZED");
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        if (auth()->user()->role === 'admin') {
            $user->update(['role' => $request->role]);
            return redirect()->route('admin.users.index')->with('success', 'User updated successfully!');
        } else {
            abort(403, "THIS ACTION IS UNAUTHORIZED");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if (auth()->user()->role === 'admin') {
            Post::all()->where('author_id', $user->id)->each(function ($post) {
                $post->tags()->detach($post->tags);
                $post->delete();
            });
            Subscription::where('user_id', $user->id)->delete();
            $user->delete();
            return redirect()->route('admin.users.index')->with('success', 'User Deleted Successfully!');
        } else {
            abort(403, "THIS ACTION IS UNAUTHORIZED");
        }
    }
}
