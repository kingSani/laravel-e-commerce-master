@extends('layouts.main')

@section('content')
<div class="my-20 p-4">
    <div class="mt-8 flex justify-center md:mx-10">
        <p class="text-3xl">
            Profile
        </p>
    </div>
    @if ($order)
        <div class="modal relative">
            <div class="modal-content bg-white shadow-lg pt-4">
                <div class="flex justify-between items center border-b border-gray-200 px-6 py-2">
                    <p class="text-3xl">Order Details</p>
                    <a href="{{ route('profile') }}"
                        class="py-1 inline-block text-center px-3 border border-transparent rounded-md font-semibold hover:text-white text-xl uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                        X
                    </a>
                </div>
                <div class="p-2 md:p-6 bg-gray-100">
                    <div class="flex flex-col items-center">
                        <div class="md:flex-1 m-4 rounded bg-white shadow-lg w-full border border-gray-300">
                            <div class="py-2 px-6 border-b border-gray-400">
                                <p class="text-2xl">Order Details</p>
                            </div>
                            <div class="m-3">
                                <p class="text-lg">Address</p>
                                <p class="">{{$order->address}}</p>
                            </div>
                            <div class="m-3">
                                <p class="text-lg">Order Date</p>
                                <p class="">{{$order->created_at}}</p>
                            </div>
                            <div class="m-3">
                                <p class="text-lg">Total price:</p>
                                <p class="text-blue-500">£{{number_format(sprintf('%0.2f', preg_replace("/[^0-9.]/", "", $order->total_price)),2)}}</p>
                            </div>
                        </div>
                        <div class="md:flex-1 m-4 rounded bg-white shadow-lg w-full border border-gray-300">
                            <div class="py-2 px-6 border-b border-gray-400">
                                <p class="text-2xl">Ordered Items</p>
                            </div>
                            @foreach ($order->orderProduct as $item)
                                <div class="p-2 border-b border-gray-300 flex items-center">
                                    <div class="cart-image flex-1 h-32 relative">
                                        <img src="/storage/products_images/{{ $item->image }}" alt="product image">
                                    </div>
                                    <div class="flex-1 text-center">
                                        {{$item->quantity}}
                                    </div>
                                    <div class="flex-1 text-center text-blue-600">
                                        £{{number_format(sprintf('%0.2f', preg_replace("/[^0-9.]/", "", $item->price)),2)}}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="flex flex-col md:flex-row md:items-start items-center md:mt-20">
        <div class="md:flex-1 m-4 rounded bg-white shadow-lg w-full border border-gray-300">
            <div class="py-2 px-6 border-b border-gray-400">
                <p class="text-2xl">Your Details</p>
            </div>
            <div class="p-6 w-full">
                <div class="my-4 w-full">
                    <x-label for="name" :value="__('Full Name')" />
    
                    <x-input disabled="true" class="block mt-1 w-full" type="text" name="name"
                        value="{{Auth()->user()->name}}" />
                </div>
                <div class="my-4 w-full">
                    <x-label for="email" :value="__('Email')" />
    
                    <x-input disabled="true" class="block mt-1 w-full" type="email" name="email"
                        value="{{Auth()->user()->email}}" />
                </div>
            </div>
        </div>
        <div class="md:flex-1 m-4 rounded bg-white shadow-lg w-full border border-gray-300">
            <div class="py-2 px-6 border-b border-gray-400">
                <p class="text-2xl">Order History</p>
            </div>
            @if (count($items) > 0)
                @foreach ($items as $item)
                <a href="/profile?id={{$item->id}}" class="hover:bg-gray-100 px-2 py-6 border-b border-gray-300 flex items-center">
                    <div class="flex-1">
                        {{count($item->orderProduct)}} product(s)
                    </div>
                    <div class="flex-1 text-center text-blue-600">
                        £{{number_format(sprintf('%0.2f', preg_replace("/[^0-9.]/", "", $item->total_price)),2)}}
                    </div>
                    <div class="flex-1 text-right">
                        {{$item->updated_at}}
                    </div>
                </a>
                @endforeach
            @else
                <div class="flex justify-center items-center">
                    <div class="flex-1 text-center py-20 text-xl">No Orders Yet</div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection