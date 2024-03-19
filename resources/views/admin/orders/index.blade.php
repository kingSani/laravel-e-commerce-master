@extends('layouts.admin')

@section('content')
<div class="mt-12 pt-20 px-4 md:px-20">
    <div class="text-center mb-10">
        <p class="text-3xl">
            Orders: {{count($items)}}
        </p>
    </div>
    @if (count($items) > 0)
        <div class="flex flex-col justify-start items-center">
            @foreach ($items as $item)
                <a href="/admin/orders/{{$item->id}}" class="my-4 shadow bg-white w-full md:w-3/5 hover:bg-gray-100 px-2 py-2 md:p-8 border-b border-gray-300 flex flex-col items-left">
                    <div class="flex-1">
                        {{$item->user->name}}
                    </div>
                    <div class="flex-1">
                        {{count($item->orderProduct)}} product(s) ordered
                    </div>
                    <div class="flex-1 text-blue-700">
                        Price: £{{number_format(sprintf('%0.2f', preg_replace("/[^0-9.]/", "", $item->total_price)),2)}}
                    </div>
                    <div class="flex-1">
                        Date ordered: {{$item->updated_at}}
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="text-center">
            <p class="text-3xl">NO ORDER YET</p>
        </div>
    @endif
    
</div>
@endsection