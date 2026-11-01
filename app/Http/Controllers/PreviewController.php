<?php

namespace App\Http\Controllers;

use App\Models\Advisory;
use App\Models\Page;
use App\Models\Post;
use Illuminate\Http\Response;

/**
 * Pratinjau draf dan konten terjadwal untuk staf (FR-46). Hanya untuk pengguna masuk dengan peran CSIRT.
 * Memakai 404 (bukan redirect ke login) agar keberadaan rute tidak terbongkar dan tidak butuh rute `login`.
 * Tautan pratinjau dibuat dari tombol "Pratinjau" di Filament Resource.
 */
class PreviewController extends Controller
{
    private const ROLES = ['superadmin', 'koordinator', 'analis', 'editor'];

    public function page(Page $page): Response
    {
        $this->authorizeStaff();

        return $this->render('pages.show', ['page' => $page, 'preview' => true]);
    }

    public function post(Post $post): Response
    {
        $this->authorizeStaff();

        return $this->render('posts.show', ['type' => $post->type, 'post' => $post, 'preview' => true]);
    }

    public function advisory(Advisory $advisory): Response
    {
        $this->authorizeStaff();

        return $this->render('advisories.show', ['advisory' => $advisory, 'preview' => true]);
    }

    private function authorizeStaff(): void
    {
        $user = auth()->user();

        abort_unless($user && method_exists($user, 'hasAnyRole') && $user->hasAnyRole(self::ROLES), 404);
    }

    private function render(string $view, array $data): Response
    {
        return response()
            ->view($view, $data)
            ->header('X-Robots-Tag', 'noindex, nofollow')
            ->header('Cache-Control', 'no-store, private');
    }
}
