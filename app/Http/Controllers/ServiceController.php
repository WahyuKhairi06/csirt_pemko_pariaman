<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Contracts\View\View;

// Katalog Layanan (FR-04): dikelompokkan reaktif / proaktif / kualitas.
class ServiceController extends Controller
{
    public function index(): View
    {
        $groups = Service::published()
            ->orderBy('sort')
            ->orderBy('name')
            ->get()
            ->groupBy(fn (Service $s) => $s->group->value);

        return view('services.index', ['groups' => $groups]);
    }
}
