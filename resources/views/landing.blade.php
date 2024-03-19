@extends('layouts.main')

@section('content')
    <div class="app-background bg-blue-300 flex-1 min-h-screen flex w-full">
        {{-- <img src="/images/app-background.jpg" alt="User Image" class='w-full flex-1'> --}}
        <div
            class="bg-black bg-opacity-75  w-full flex items-center justify-center text-gray-200 text-3xl md:text-5xl text-center md:mt-10 ">
            Come and game with us 
        
            <div class=" justify-center pt-24  mt-4 ">
                <a class="btn" href="{{ route('products')}}"
                    style="background: #3B5499; color: #ffffff; padding: 10px; width: 100%; text-align: center; display: block; border-radius:3px;">
                    Shop Now
                </a>
            </div>
        </div>  
      

    
    </div>
@endsection