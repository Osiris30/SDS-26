<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function __invoke(): View
    {
        $now = now();

        return view('admin.dashboard', [
            'totalPosts' => Post::count(),
            'publishedPosts' => Post::where('is_published', true)->whereNotNull('published_at')->where('published_at', '<=', $now)->count(),
            'draftPosts' => Post::where('is_published', false)->count(),
            'scheduledPosts' => Post::where('is_published', true)->where('published_at', '>', $now)->count(),
            'categoryCount' => Category::count(),
            'latestPosts' => Post::with('category')->latest('updated_at')->take(6)->get(),
        ]);
    }
}
