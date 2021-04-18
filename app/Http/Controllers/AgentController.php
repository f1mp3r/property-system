<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    public function list()
    {
        return view('agent.list', ['agents' => Agent::paginate()]);
    }

    public function view(Agent $agent)
    {
        return view('agent.view', compact('agent'));
    }

    public function create()
    {
        return view('agent.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $valid = $request->validate([
            'first_name' => ['required', 'string', 'between:1,50'],
            'last_name' => ['required', 'string', 'between:1,50'],
            'phone' => ['nullable', 'string', 'between:1,50'],
            'email' => ['nullable', 'email', 'between:1,200'],
            'address' => ['nullable', 'string', 'between:1,100'],
        ]);

        Agent::create($valid);

        return response()->redirectToRoute('agent.list')
            ->with('status', 'Agent created')
        ;
    }
}
