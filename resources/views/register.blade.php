@extends('layouts.app')

@section('content')


<div style="width: 30%; margin-top: 15%; margin-left: 35%;">
    <form action="{{URL::to('/register')}}" method="POST">
        <h3>Register User </h3>
        <div class="form-group mt-2">
            <input name="Name" type="text" class="form-control" placeholder="Name">
        </div>
        <div class="form-group mt-2">
            <input name="StaffID" type="text" class="form-control" placeholder="Staff ID">
        </div>
        <div class="form-group mt-2">
            <input name="PhoneNumber" type="text" class="form-control" placeholder="Phone Number">
        </div>
        <div class="form-group mt-2">
            <input name="Username" type="text" class="form-control" placeholder="User Name">
        </div>
        <div class="form-group mt-2">
            <input name="Password" type="password" class="form-control" placeholder="Password">
        </div>
        <div class="form-group mt-2">
            <input name="Password_confirmation" type="password" class="form-control" placeholder="Confirm Password">
        </div>
        <div class="form-group mt-2">
            <button type="submit" class="btn btn-primary ">Register</button>
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