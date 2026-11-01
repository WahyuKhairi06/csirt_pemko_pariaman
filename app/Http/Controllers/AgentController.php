<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

// Agen Siber OPD (FR-03). Filter OPD lewat query string (?opd=...), hanya membaca.
class AgentController extends Controller
{
    public function index(Request $request): View
    {
        $opd = trim((string) $request->query('opd'));

        $agents = Agent::active()
            ->when($opd !== '', fn ($q) => $q->where('opd', mb_substr($opd, 0, 150)))
            ->orderBy('opd')
            ->orderBy('sort')
            ->orderBy('name')
            ->get();

        $opds = Agent::active()->orderBy('opd')->distinct()->pluck('opd');

        return view('agents.index', ['agents' => $agents, 'opds' => $opds, 'opd' => $opd]);
    }
}
