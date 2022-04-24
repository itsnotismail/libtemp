@extends('layouts.app')

@section('content')
{{-- 
@if (Route::has('login'))
    <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
        @auth
            <a href="{{ url('/home') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Home</a>
        @else
            <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
            @endif
        @endauth
    </div>
@endif --}}

<div class="container">
    <div style="background-color: grey; height: 20em;width:100%">
        <div class="row" >
            <div class="col-xl-2" >
                <img src="{{URL::to('/')}}/img/logo.png"  style="width:100%">
            </div>
            <div class="col-xl-6"><p style="color: white;margin:5%;font-size: 20px">
                Cyryx College will be widely recognized as the premier private college which develops global citizens, 
                ready for the world, through excellence in education, scholarship, and research, developed,
                 delivered and rooted in the Maldives and the values of its people.</p>
            </div>
            <div class="col-xl-4">
                <div class="d-grid gap-2" style="margin:5%">
                    <a href="{{URL::to('/login')}}"><button class="btn btn-info"> Login</button></a>
                    <a href="{{URL::to('/register')}}" ><button class="btn btn-primary">Register</button></a>
                  </div>
            </div>
        </div>
    </div>
    
</div>
    
@endsection