@extends('templates.dashboard')

@section('title', 'New agent')

@section('content')
    <form action="{{ route('agent.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="first_name" class="form-label">First name</label>
            <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" id="first_name" placeholder="First name">
            @error('first_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="last_name" class="form-label">Last name</label>
            <input type="text" class="form-control" name="last_name" id="last_name @error('last_name') is-invalid @enderror" placeholder="Last name">
            @error('last_name')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="tel" class="form-control" name="phone" id="phone @error('phone') is-invalid @enderror" placeholder="Phone">
            @error('phone')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" id="email @error('email') is-invalid @enderror" placeholder="Email">
            @error('email')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" name="address" id="address @error('address') is-invalid @enderror" placeholder="Address">
            @error('address')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
