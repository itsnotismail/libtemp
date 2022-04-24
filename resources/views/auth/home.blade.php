@extends('layouts.app')

@section('content')
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
            
        </div>
    </div>
    
</div>


@endsection