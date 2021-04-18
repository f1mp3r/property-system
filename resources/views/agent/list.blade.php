@extends('templates.dashboard')

@section('title', 'Agents')

@section('content')
    <a href="{{ route('agent.create') }}" class="btn btn-info">New agent</a>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>Agent</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Address</th>
            <th>View</th>
        </tr>
        </thead>
        <tbody>
        @foreach($agents as $agent)
            <tr>
                <td>{{ $agent->id }}</td>
                <td>{{ $agent->full_name }}</td>
                <td>{{ $agent->phone }}</td>
                <td>{{ $agent->email }}</td>
                <td>{{ $agent->address }}</td>
                <td><a href="{{ route('agent.view', $agent) }}">View</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $agents->links() !!}
@endsection
