@extends('layouts.admin')

@section('content')
<div class="mt-28 p-4">
    <div class="flex justify-center md:mx-10">
        <p class="text-3xl">
            Admin Section
        </p>
    </div>
    <div class="flex flex-col md:flex-row md:items-start items-center md:mt-8">
        <div class="md:flex-1 m-4 rounded bg-white shadow-lg w-full border border-gray-300">
            <div class="py-2 px-6 border-b border-gray-400">
                <p class="text-2xl">Customer Details</p>
            </div>
            <div class="p-6 w-full">
                <div class="my-4 w-full">
                    <x-label for="name" :value="__('Full Name')" />

                    <x-input disabled="true" class="block mt-1 w-full" type="text" name="name"
                        value="{{$customer->name}}" />
                </div>
                <div class="my-4 w-full">
                    <x-label for="email" :value="__('Email')" />

                    <x-input disabled="true" class="block mt-1 w-full" type="email" name="email"
                        value="{{$customer->email}}" />
                </div>
                <div class="my-4 w-full">
                    <x-label for="date" :value="__('Date Registered')" />

                    <x-input disabled="true" class="block mt-1 w-full" type="text" name="date"
                        value="{{$customer->created_at}}" />
                </div>
            </div>
        </div>
        <div class="md:flex-1 m-4 rounded bg-white shadow-lg w-full border border-gray-300">
            <div class="py-2 px-6 border-b border-gray-400">
                <p class="text-2xl">Order History</p>
            </div>
            @if (count($orders) > 0)
                @foreach ($orders as $item)
                    <a href="/admin/orders/{{$item->id}}"
                        class="hover:bg-gray-100 px-2 py-6 border-b border-gray-300 flex items-center">
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
    <div class="flex flex-col md:flex-row items-left md:items-center justify-between m-4">
        <p class="text-2xl">
            Give customer the Admin role. (<span class="text-red-700">
                User must have not made an order yet or have items in cart
            </span>)
        </p>
        <form method="POST" action="/admin/customer" class="inline-block">
            @csrf
            <input id="id" name="id" type="hidden" value="{{$customer->id}}">
            <x-button class="mt-6 md:mt-1 bg-red-700 hover:bg-red-600 active:bg-red-800 focus:border-red-800 ring-red-400">
                {{ __('Upgrade User To Admin') }}
            </x-button>
        </form>
    </div>
</div>
@endsection