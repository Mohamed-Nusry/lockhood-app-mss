@extends('layouts.app')

@section('content')
<div class="">
    <div class="centered-div ml-5">   
            <h4 >Welcome to Lockhood System</h4>
        @if(Auth::check())

            @if(Auth::user()->first_name != null && Auth::user()->last_name != null)        
             
                <h5 class="text-center">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</h5>
           
            @endif
        
        @endif
       

    </div>
</div>
@endsection
