@extends('templates.dashboard')

@section('title', 'Dashboard')

@section('content')
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Property</th>
                <th>View</th>
            </tr>
        </thead>
        <tbody>
            @foreach($properties as $property)
            <tr>
                <td>{{ $property->id }}</td>
                <td>{{ $property->summary }}</td>
                <td><a href="{{ route('view', $property) }}">View</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {!! $properties->links() !!}
@endsection
