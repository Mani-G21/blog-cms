<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Plan;
use App\Models\Post;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $posts = Post::where('author_id', auth()->user()->id)->orderBy('view_count', 'desc')->get();
        $viewCount = $posts->sum('view_count');
        $subscriptionPlan = Subscription::all()->where('user_id', auth()->user()->id)
            ->where('status', 'active');
        $articlesRemaining = null;

        if ($subscriptionPlan->count() != 0) {

            $subscriptionPlan = $subscriptionPlan->first();
            $articlesRemaining = $subscriptionPlan['articles_remaining'];
            $planName = Plan::all()->where('id', $subscriptionPlan['plan_id'])->pluck('name')[0];
        } else {
            $planName = "Free Plan";
            $articlesRemaining = 3 - auth()->user()->articles_generated;
        }

        return view('admin.dashboard', compact([
            'posts',
            'viewCount',
            'articlesRemaining',
            'planName'
        ]));
    }

    public function logout()
    {
        User::find(auth()->user()->id)->update(['user_token' => null]);
        Auth::logout();
        return redirect('login');
    }

    public function profile()
    {
        $user = auth()->user();
        return view('admin.profile.edit', compact([
            'user'
        ]));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();
        if ($request->hasFile('profile_pic')) {
            $validated['profile_pic'] = $request->file('profile_pic')->store('profilePics', 'public');
        }
        $user->update($validated);
        return redirect()->route('admin.dashboard')->with('success', "Profile updated successfully.");
    }
}
