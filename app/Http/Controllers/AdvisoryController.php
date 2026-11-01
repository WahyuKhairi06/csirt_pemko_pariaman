<?php

namespace App\Http\Controllers;

use App\Enums\Severity;
use App\Models\Advisory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

// Advisori & peringatan dini (FR-30, FR-31).
class AdvisoryController extends Controller
{
    public function index(Request $request): View
    {
        $severity = Severity::tryFrom((string) $request->query('tingkat'));

        $advisories = Advisory::published()
            ->when($severity, fn ($q) => $q->where('severity', $severity->value))
            ->orderByRaw('COALESCE(published_at, created_at) DESC')
            ->paginate(10)
            ->withQueryString();

        return view('advisories.index', ['advisories' => $advisories, 'severity' => $severity]);
    }

    public function show(string $slug): View
    {
        $advisory = Advisory::published()->where('slug', $slug)->firstOrFail();

        return view('advisories.show', ['advisory' => $advisory, 'preview' => false]);
    }
}
