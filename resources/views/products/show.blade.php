@extends('layouts.main')

@section('content')
    <div class="md:flex-1 md:flex md:flex-col mt-20 py-10 mx-6 md:mx-20">
        <div class="flex flex-start items-center">
            <a href="{{route('products')}}" class="hover:underline">
                <p class="text-2xl text-blue-600">
                    Back to Store
                </p>
            </a>
        </div>

        <div class="flex md:flex-1 md:items-center flex-col md:flex-row w-full md:mx-10 mt-8 md:my-6">
            <div class="md:flex-1 single-card relative" style="background: initial">
                <img src="/storage/products_images/{{$product->image}}" alt="product image">
            </div>
            <div class="md:flex-1 py-5 px-4">
                <div class="md:pr-52">
                    <p class="text-4xl text-blue-600">{{$product->name}}</p>
                    <div class="border-b md:flex h-1 border-gray-300 py-2"></div>
                    <div class="border-b md:flex border-gray-300 py-3">
<span class="text-2xl mr-3 md:flex-1">Type:</span>
<span class="text-2xl font-bold md:flex-5">{{$product->type}}</span>
                    </div>
                    <div class="border-b md:flex border-gray-300 py-3">
<span class="text-2xl mr-3 md:flex-1">Color:</span>
<span class="text-2xl font-bold md:flex-5">{{$product->color}}</span>
                    </div>
                    <div class="border-b md:flex border-gray-300 py-3">
<span class="text-2xl mr-3 md:flex-1">Size:</span>
<span class="text-2xl font-bold md:flex-5">{{$product->size}}</span>
                    </div>
                    <div class="border-b md:flex border-gray-300 py-3">
<span class="text-2xl mr-3 md:flex-1">Price:</span>
<span class="text-2xl font-bold md:flex-5">£{{number_format(sprintf('%0.2f', preg_replace("/[^0-9.]/", "", $product->price)),2)}}</span>
                    </div>
                    <form method="POST" action="/products/{{$product->id}}">
                        @csrf
                        <x-button class="mt-4 w-full block py-4" style="display: block">
                        
                            @if ($found)
                                {{ __('Add quantity') }}
                            @else
                                {{ __('Add to cart') }}
                            @endif
                        </x-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection