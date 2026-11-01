<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Contracts\View\View;

// Dokumen & RFC-2350 (FR-07): daftar dikelompokkan per kategori.
class DocumentController extends Controller
{
    public function index(): View
    {
        $groups = Document::published()
            ->orderBy('sort')
            ->orderBy('title')
            ->get()
            ->groupBy(fn (Document $d) => $d->category->value);

        return view('documents.index', ['groups' => $groups]);
    }
}
