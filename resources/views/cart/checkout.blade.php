@extends('layouts.main')

@section('content')
<div class="mt-28 p-4">
    <div class="flex justify-center md:mx-10">
        <p class="text-3xl">
            Checkout Products
        </p>
    </div>
    <div class="flex flex-col md:flex-row md:items-start items-center">
        <div class="md:flex-1 m-4 rounded bg-white shadow-lg w-full border border-gray-300">
            <div class="py-2 px-6 border-b border-gray-400">
                <p class="text-2xl">Cart Items</p>
            </div>
            @foreach ($items as $item)
                <div class="p-2 border-b border-gray-300 flex items-center">
                    <div class="cart-image flex-1 h-32 relative">
                        <img src="/storage/products_images/{{ $item->product->image }}" alt="product image">
                    </div>
                    <div class="flex-1 text-center">
                        {{$item->quantity}}
                    </div>
                    <div class="flex-1 text-center text-blue-600">
                        £{{number_format(sprintf('%0.2f', preg_replace("/[^0-9.]/", "", $item->product->price)),2)}}
                    </div>
                </div>
            @endforeach
            <div class="flex justify-end p-4">
                <p class="text-xl">Total Price: £{{number_format(sprintf('%0.2f', preg_replace("/[^0-9.]/", "", $total_price)),2)}}</p>
            </div>
        </div>
        <div class="md:flex-1 m-4 rounded bg-white shadow-lg w-full border border-gray-300">
            <div class="py-2 px-6 border-b border-gray-400">
                <p class="text-2xl">Confirm Order</p>
            </div>
            <form action="/cart/checkout" method="POST">
                @csrf
                <div class="p-6 w-full">
                    <div class="my-4 w-full">
                        <x-label for="name" :value="__('Full Name')" />
                    
                        <x-input disabled="true" class="block mt-1 w-full" type="text" name="name" value="{{Auth()->user()->name}}" />
                    </div>
                    <div class="my-4 w-full">
                        <x-label for="email" :value="__('Email')" />
                    
                        <x-input disabled="true" class="block mt-1 w-full" type="email" name="email" value="{{Auth()->user()->email}}" />
                    </div>
                    <div class="my-4">
                        <x-label for="address" :value="__('Address')" />
                    
                        <x-input type="text" class="block mt-1 w-full" name="address" required autofocus/>
                    </div>
                    <div class="">
                        <x-button style="display: block" class="w-full p-3 mt-5 bg-blue-700 hover:bg-blue-600 active:bg-blue-800 focus:border-blue-800 ring-blue-400">
                            {{ __('Order Now') }}
                        </x-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection