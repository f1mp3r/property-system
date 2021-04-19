<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class AgentController extends Controller
{
    public function list(): LengthAwarePaginator
    {
        $query = DB::table('agents')
            ->leftJoin('agents_properties', 'agents.id', '=', 'agents_properties.agent_id')
            ->leftJoin('properties', 'properties.id', '=', 'agents_properties.property_id')
            ->selectRaw('CONCAT(agents.first_name, " ", agents.last_name) as name')
            ->selectRaw('GROUP_CONCAT(properties.address) as property')
            ->selectRaw('SUM(properties.price) as total_price')
            ->groupByRaw('agents.id')
        ;

        return $query->paginate();
    }
}
