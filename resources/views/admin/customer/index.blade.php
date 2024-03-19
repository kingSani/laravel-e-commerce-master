@extends('layouts.admin')

@section('content')
<div class="mt-12 py-20 px-4 md:px-20">
    <div class="text-center mb-10">
        <p class="text-3xl">
            Users Registered
        </p>
    </div>
    <div class="px-8 mb-8 flex items-center justify-between">
        <p class="text-3xl">Customers</p>
        <p class="text-3xl">{{count($customers)}} user(s)</p>
    </div>
    @if (count($customers) > 0)
        <div class="flex flex-col justify-start items-center">
            @foreach ($customers as $item)
                <a href="/admin/customer/{{$item->id}}" class="my-4 shadow bg-white w-full hover:bg-gray-100 px-2 py-2 md:py-8 border-b border-gray-300 flex flex-col md:flex-row items-left md:items-center">
                    <div class="flex-1">
                        {{$item->name}}
                    </div>
                    <div class="flex-1 text-center text-blue-600">
                        {{$item->email}}
                    </div>
                    <div class="flex-1 text-right">
                        {{count($item->order)}} order(s)
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="text-center">
            <p class="text-3xl">NO REGISTERED CUSTOMER YET</p>
        </div>
    @endif
    
    <div class="px-8 mb-8 mt-10 flex items-center justify-between">
        <p class="text-3xl">Admins</p>
        <p class="text-3xl">{{count($admins)}} admin(s)</p>
    </div>

    @if (count($admins) > 0)
        <div class="flex flex-col justify-start items-center">
            @foreach ($admins as $item)
                <a class="my-4 shadow bg-white w-full hover:bg-gray-100 px-2 py-2 md:py-8 border-b border-gray-300 flex flex-col md:flex-row items-left md:items-center">
                    <div class="flex-1">
                        {{$item->name}}
                    </div>
                    <div class="flex-1 text-right text-blue-600">
                        {{$item->email}}
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="text-center">
            <p class="text-3xl">NO REGISTERED ADMIN YET</p>
        </div>
    @endif
</div>
@endsection