<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Jobs\DispatchPostNotificationJob;
use App\Mail\NewBlogNotification;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

use function Illuminate\Log\log;

class PostsController extends Controller
{
    public function index()
    {
        if(Gate::allows('viewAny', \App\Models\Post::class)){
            $posts = Post::with('category')->with('tags')->latest()->paginate(20);
        }else{
            $posts = Post::where('author_id', auth()->user()->id)->latest()->paginate(20);
        }

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
            DispatchPostNotificationJob::dispatch($post->id);

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
        if($post->author_id !== auth()->id()) {
            abort(403);
        }

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

    public function uploadImage(Request $request){
        if($request->hasFile('image')){
            $file = $request->file('image');
            $path = $file->store('blog_images', 'public');

            return response()->json([
                'success' => true,
                'url' => asset('storage/'.$path)
            ]);
        }

        return response()->json(['success' => false], 400);
    }

    private function generatePrompt($title, $excerpt) {
        // if(!auth()->user()->canGenerateArticle()){
        //     return response()->json(['content' => 'You have reached your AI Article Generation Limit!', 'status' => 401]);
        // }
        $prompt = <<<PROMPT
            You are a professional content writer and I want you to generate an HTML blog article with the following specifications:
            Title: $title
            Excerpt: $excerpt
            Instructions:
                * Write the article in a conversational and engaging tone.
                * Do not include excerpt and title in the article that you write.
                * Use appropriate HTML tags for structure such as as <p>, <h2>, <h3>, <ul>, <li>, <code>, <blockquote> and so on.
                * Include atleast 4 headings to break the contents, and they all should be wrapped in h3 tag.
                * Ensure the HTML code is valid and well formatted.
                * Do not include any CSS styling.
                * Do not include any JavaScript
                * Focus on providing information closely related to the given title and excerpt.
                * If applicable, include the summary or conclusion at the end of article, whose title should be wrapped in h4 tag.
        PROMPT;
        return $prompt;
    }

    public function generateAI(Request $request, $token) {
        $user = User::where('user_token', $token)->firstOrFail();
        if(!$user->canGenerateArticle()){
            return response()->json(['content' => "You have reached your ai artice generation limit", 'status' => 401]);
        }
        $title = $request->title;
        $excerpt = $request->excerpt;

        $prompt = $this->generatePrompt($title, $excerpt);

        $client = new Client();
        $apiKey = env('GEMINI_API_KEY');
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}";

        $payload = [
            'contents'=>[[
                'parts'=>[[
                    'text'=> $prompt
                ]]]
            ]
        ];

        $response = $client->post($url, [
            'json' => $payload,
            [
                'headers'=> ['Content-Type'=> 'application/json']
            ]
        ]);

        if($response->getStatusCode() === 200) {
            $responseData = json_decode($response->getBody(), true);
            Log::info($responseData['candidates'][0]['content']['parts'][0]['text']);

            $user->activeSubscription()?->decrement('articles_remaining');
            $user->increment('articles_generated');
            return response()->json(['content' =>$responseData['candidates'][0]['content']['parts'][0]['text'], 'status' => 200]);

        }

        return response()->json(['content'=>"Some issue with our AI model", 'status'=>403]);
}

}
