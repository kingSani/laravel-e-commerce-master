@extends('layouts.main')

@section('content')
<div class="mt-28 p-4">
    <div class="flex justify-between md:mx-10">
        <p class="text-2xl text-red-700">Your Cart</p>
        <p class="text-xl text-red-700">{{count($items)}} item(s)</p>
    </div>
    @if (count($items) > 0)
        @foreach ($items as $item)
            <div class="flex flex-col md:hidden bg-white my-4 shadow-lg">
                <div class="flex items-center p-4">
                    <a href='products/{{$item->product_id}}' class="cart-image flex-1 h-40 relative ">
                        <img src="/storage/products_images/{{ $item->product->image }}" alt="product image">
                    </a>
                    <div class="flex-1 m-4">
                        <div class="text-xl text-red-700">
                            {{$item->product->name}}
                        </div>
                        <div class="text-lg">
                            {{$item->product->type}}
                        </div>
                        <div class="text-lg">
                            {{$item->product->size}}
                        </div>
                        <div class="text-lg">
                            {{$item->product->price}}
                        </div>
                    </div>
                </div>
                <div class="border-t border-gray-400 flex items-center py-4">
                    <div class="flex justify-center items-center flex-1 text-center text-lg">
                        <form method="POST" action="/products/{{$item->product_id}}" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <x-button class="bg-red-700 hover:bg-red-600 active:bg-red-800 focus:border-red-800 ring-red-400">
                                {{ __('-') }}
                            </x-button>
                        </form>
                        <p class="px-5">
                            {{$item->quantity}}
                        </p>
                        <form method="POST" action="/products/{{$item->product_id}}" class="inline-block">
                            @csrf
                            <x-button class="bg-red-700 hover:bg-red-600 active:bg-red-800 focus:border-red-800 ring-red-400">
                                {{ __('+') }}
                            </x-button>
                        </form>
                    </div>
                    <div class="flex-1 text-center text-lg">
                        {{$item->product->price * $item->quantity}}
                    </div>
                </div>
            </div>
            <div class="hidden md:flex m-6 bg-white shadow-lg p-4 justify-between items-center">
                <a href='products/{{$item->product_id}}' class="cart-image flex-1 h-40 relative ">
                    <img src="/storage/products_images/{{ $item->product->image }}" alt="product image">
                </a>
                <div class="flex-1 text-center text-lg border-l border-gray-400">
                    {{$item->product->type}}
                </div>
                <div class="flex-1 text-center text-lg border-l border-gray-400">
                    {{$item->product->size}}
                </div>
                <div class="flex-1 text-center text-lg border-l border-gray-400">
                    £{{number_format(sprintf('%0.2f', preg_replace("/[^0-9.]/", "", $item->product->price * $item->quantity)),2)}}
                </div>
                <div class="flex justify-center items-center flex-1 text-center text-lg border-l border-gray-400">
                    <form method="POST" action="/products/{{$item->product_id}}" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <x-button class="bg-red-700 hover:bg-red-600 active:bg-red-800 focus:border-red-800 ring-red-400">
                            {{ __('-') }}
                        </x-button>
                    </form>
                    <p class="px-5">
                        {{$item->quantity}}
                    </p>
                    <form method="POST" action="/products/{{$item->product_id}}" class="inline-block">
                        @csrf
                        <x-button class="bg-red-700 hover:bg-red-600 active:bg-red-800 focus:border-red-800 ring-red-400">
                            {{ __('+') }}
                        </x-button>
                    </form>
                </div>
                <div class="flex-1 text-center text-lg border-l border-gray-400">
                    £{{number_format(sprintf('%0.2f', preg_replace("/[^0-9.]/", "", $item->product->price * $item->quantity)),2)}}
                </div>
            </div>
        @endforeach
        <div class="flex justify-end items-center my-6 md:mx-6 p-3 md:p-6 bg-white rounded shadow-lg">
            <p class="text-2xl text-red-700 text-white">Total Price:</p>
            <p class="text-3xl text-red-700 text-white mx-5">£{{number_format(sprintf('%0.2f', preg_replace("/[^0-9.]/", "", $total_price)),2)}}</p>
        </div>
        <div class="flex my-6 justify-end md:mr-6">
            <a href="{{ route('products') }}" style="display: block" class="md:text-xl md:w-1/4 text-white text-center rounded shadow-lg py-2 md:px-6 flex-1 md:flex-none bg-blue-700 mr-2 hover:bg-blue-600">
                {{ __('Continue shopping') }}
            </a>
            <a href="{{ route('cart.checkout') }}" style="display: block" class="md:text-xl md:w-1/4 text-white text-center rounded shadow-lg py-2 md:px-6 flex-1 md:flex-none bg-green-700 ml-2 hover:bg-green-600">
                {{ __('Checkout') }}
            </a>
        </div>
    @else
        <div class="single-card flex justify-center items-center" style="background: initial">
            <p class="text-4xl text-center text-blue-800">No items in cart</p>
        </div>
    @endif
</div>
@endsection