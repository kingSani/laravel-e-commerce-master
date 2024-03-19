@extends('layouts.admin')

@section('content')
    <div class="mt-12 pt-20 px-4 md:px-20">
        <div class="text-center mb-10">
            <p class="text-3xl">
                Admin Section
            </p>
        </div>
        <div class="p-2 md:p-6">
            <div class="flex items-start flex-col md:flex-row">
                <div class="md:flex-1 md:m-4 rounded bg-white shadow-lg w-full border border-gray-300">
                    <div class="py-2 px-6 border-b border-gray-400">
                        <p class="text-2xl">Order Details</p>
                    </div>
                    <div class="m-3">
                        <p class="text-lg">Name</p>
                        <p class="">{{$order->user->name}}</p>
                    </div>
                    <div class="m-3">
                        <p class="text-lg">Email Address</p>
                        <p class="">{{$order->user->email}}</p>
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
                        <p class="text-blue-500">£{{number_format(sprintf('%0.2f', preg_replace("/[^0-9.]/", "",
                            $order->total_price)),2)}}</p>
                    </div>
                </div>
                <div class="md:flex-1 md:m-4 mt-4 rounded bg-white shadow-lg w-full border border-gray-300">
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
@endsection