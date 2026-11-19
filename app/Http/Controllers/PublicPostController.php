<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicPostController extends Controller
{
    public function index(Request $request): View
    {
        $category = $request->string('categoria')->toString();

        $posts = Post::query()
            ->with(['category', 'author'])
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->when($category, fn ($query) => $query->whereHas('category', fn ($categories) => $categories->where('slug', $category)))
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        return view('posts.index', [
            'posts' => $posts,
            'categories' => Category::withCount(['posts' => fn ($query) => $query->where('is_published', true)->whereNotNull('published_at')->where('published_at', '<=', now())])->orderBy('name')->get(),
            'selectedCategory' => $category,
        ]);
    }
}
