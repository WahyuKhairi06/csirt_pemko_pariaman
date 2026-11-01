<?php

namespace App\Http\Controllers;

use App\Enums\PostType;
use App\Models\Post;
use Illuminate\Contracts\View\View;

// Berita dan Edukasi (FR-20, FR-21): /berita, /edukasi. Hanya konten berstatus terbit.
class PostController extends Controller
{
    public function index(string $path): View
    {
        $type = PostType::fromPath($path) ?? abort(404);

        $posts = Post::published()
            ->where('type', $type->value)
            ->with('category')
            ->orderByRaw('COALESCE(published_at, created_at) DESC')
            ->paginate(9);

        return view('posts.index', ['type' => $type, 'posts' => $posts]);
    }

    public function show(string $path, string $slug): View
    {
        $type = PostType::fromPath($path) ?? abort(404);

        $post = Post::published()
            ->where('type', $type->value)
            ->where('slug', $slug)
            ->with('category')
            ->firstOrFail();

        return view('posts.show', ['type' => $type, 'post' => $post, 'preview' => false]);
    }
}
