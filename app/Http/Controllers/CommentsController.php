<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Reply;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

       return redirect()->route('frontend.show', Post::find($request->postId)->slug)->with('success', 'Comment uploaded successfully');
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

    private function generatePrompt($comment) {
        $prompt = <<<PROMPT
    You are a professional content writer. Validate whether the comment is vulgar, inappropriate, offensive, abusive, seductive, manipulation or harassing.
    If YES, return: "NO"
    Reason: "The comment is not valid as it violates our company's terms."
    If appropriate, return: "TRUE"
    The comment: "$comment"
    PROMPT;
        return $prompt;
    }

    public function validateAI(Request $request) {
        if (!$request->has('comment')) {
            return response()->json(['content' => "No comment provided", 'status' => 400]);
        }

        $comment = $request->comment;
        $prompt = $this->generatePrompt($comment);

        $client = new \GuzzleHttp\Client();
        $apiKey = env('GEMINI_API_KEY');

        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}";

        $payload = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ]
        ];

        try {
            $response = $client->post($url, [
                'headers' => [
                    'Content-Type' => 'application/json'
                ],
                'json' => $payload
            ]);

            if ($response->getStatusCode() === 200) {
                $responseData = json_decode($response->getBody(), true);
                $result = $responseData['candidates'][0]['content']['parts'][0]['text'] ?? "Some issue with our AI model";
                return response()->json(['content' => $result, 'status' => 200]);
            }
        } catch (\Exception $e) {
            return response()->json(['content' => "AI validation failed: " . $e->getMessage(), 'status' => 500]);
        }

        return response()->json(['content' => "Some issue with our AI model", 'status' => 403]);
    }

}
