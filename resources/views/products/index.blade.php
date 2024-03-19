@extends('layouts.main')

@section('content')
    <div class="mt-20 py-10 mx-2 md:mx-20 ">
        
        <div class="flex justify-start items-center mx-4">
            <p class="text-3xl">All Accessories</p>
            {{-- <p class="text-xl text-blue-500">{{count($products)}} Item(s) found</p> --}}
        </div>

        @if (count($products) > 0)
            {{$products->links()}}
            <div class="flex justify-start w-full flex-wrap">
                @foreach ($products as $item)
                    <div class="product-card shadow-lg relative">
                        <a href="/products/{{$item->id}}">
                            <div class="h-48 md:h-60 flex relative overflow-hidden">
                                <img src="/storage/products_images/{{$item->image}}" alt="product image">
                            </div>
                            <div class="p-2">
                                <p class="text-2xl text-blue-600">{{$item->name}}</p>
                                <p class="text-xl">{{$item->color}}</p>
                                <p class="text-xl">£{{number_format(sprintf('%0.2f', preg_replace("/[^0-9.]/", "", $item->price)),2)}}</p>
                            </div>
                        </a>
                  
                        @if ($item->out_of_stock == 1)
                            <div class="absolute right-0 left-0 top-0 bottom-0 bg-opacity-50 bg-gray-100 flex items-center justify-center cursor-default">
                                <p class="text-2xl md:text-4xl text-center text-red-500 transform -rotate-45 font-bold">Out of Stock</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
            {{$products->links()}}
        @else
            <div class="single-card flex justify-center items-center" style="background: initial">
                <p class="text-4xl text-center text-blue-800">NO PRODUCT YET</p>
            </div>
        @endif
    </div>
@endsection