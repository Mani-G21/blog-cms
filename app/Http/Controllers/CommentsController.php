<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Reply;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        if($request->on){
            Reply::insert(['comment_id' => $request->on, 'sender' => $request->name, 'content' => $request->message, 'created_at' => now(), 'updated_at' => now()]);
        }
        else{
            Comment::insert(['post_id' => $request->postId, 'on' => $request->on, 'sender' => $request->name, 'content' => $request->message, 'created_at' => now(), 'updated_at' => now()]);
        }

       return redirect()->route('frontend.show', Post::find($request->postId)->slug);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
