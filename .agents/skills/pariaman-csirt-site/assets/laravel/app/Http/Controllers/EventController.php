<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Contracts\View\View;

// Agenda (FR-22): yang akan datang dipisah dari yang sudah lewat.
class EventController extends Controller
{
    public function index(): View
    {
        $upcoming = Event::published()->where('starts_at', '>=', now())->orderBy('starts_at')->get();
        $past = Event::published()->where('starts_at', '<', now())->orderByDesc('starts_at')->limit(12)->get();

        return view('events.index', ['upcoming' => $upcoming, 'past' => $past]);
    }
}
