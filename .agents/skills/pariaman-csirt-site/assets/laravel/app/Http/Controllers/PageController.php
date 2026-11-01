<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

// Beranda dan halaman dinamis /{slug} (PRD.md FR-01, FR-02). Hanya membaca; konten dari panel admin.
class PageController extends Controller
{
    public function home(): View
    {
        $page = Page::published()->where('is_home', true)->firstOrFail();

        return view('pages.show', ['page' => $page, 'preview' => false]);
    }

    public function show(string $slug): View|RedirectResponse
    {
        abort_if(in_array($slug, Page::RESERVED_SLUGS, true), 404);

        $page = Page::published()->where('slug', $slug)->firstOrFail();

        // Beranda hanya hidup di "/", agar tidak ada dua URL untuk satu halaman.
        if ($page->is_home) {
            return redirect('/', 301);
        }

        return view('pages.show', ['page' => $page, 'preview' => false]);
    }
}
