<?php

namespace App\Http\Controllers;

use App\Enums\AgentJobTypeEnum;
use App\Models\Agent;
use App\Models\Property;
use BenSampo\Enum\Exceptions\InvalidEnumKeyException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function list()
    {
        return view('index', ['properties' => Property::paginate()]);
    }

    public function view(Property $property)
    {
        return view(
            'property.view',
            [
                'property' => $property,
                'agents' => Agent::all()->map(fn ($agent) => ['value' => $agent->id, 'label' => $agent->full_name])->toArray(),
            ]
        );
    }

    /**
     * @param Property $property
     * @param Request $request
     * @return JsonResponse
     * @throws InvalidEnumKeyException
     */
    public function addAgent(Property $property, Request $request): JsonResponse
    {
        $validated = $request->validate([
            'type' => ['required', 'in:' . implode(',', AgentJobTypeEnum::getKeys())],
            'agent' => ['required', 'exists:agents,id']
        ]);

        $property->agents()->syncWithoutDetaching([
            $validated['agent'] => [ 'job_type' => AgentJobTypeEnum::fromKey($validated['type'])->value ]
        ]);

        return response()->json(['ok' => true]);
    }

    public function deleteAgent(Property $property, Agent $agent): RedirectResponse
    {
        $property->agents()->detach($agent);

        return response()->redirectToRoute('view', $property);
    }
}
