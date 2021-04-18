@extends('templates.dashboard')

@section('title', 'Agent view')

@section('content')
    <h2>{{ $agent->full_name }}</h2>
    <p>Phone: {{ $agent->phone }}</p>
    <p>Email: {{ $agent->email }}</p>
    <p>Address: {{ $agent->address }}</p>
@endsection
