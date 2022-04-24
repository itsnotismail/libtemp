@extends('layouts.app')

@section('content')

<div style="width: 30%; margin-top: 15%; margin-left: 35%;">
    <form action="{{URL::to('/login')}}" method="POST">
        <h3>Login </h3>
        <div class="form-group mt-2">
            <input name="username" type="text" class="form-control" placeholder="Username">
        </div>
        <div class="form-group mt-2">
            <input name="password" type="password" class="form-control" placeholder="Password">
        </div>
        <div class="form-group mt-2">
            <button type="submit" class="btn btn-primary ">Login</button>
        </div>
        {{-- Show Errors --}}
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </form>
</div>


@endsection