@extends('layouts.admin')

@section('content')
<div class="mt-12 py-20 px-4 md:px-20">
    <div class="text-center mb-10">
        <p class="text-3xl">
            Admin Section
        </p>
    </div>
    @if ($add == 1)
        <div class="modal relative">
            <div class="modal-content bg-white shadow-lg pt-4">
                <div class="flex justify-between items center border-b border-gray-200 px-6 py-2">
                    <p class="text-3xl">Add Product</p>
                    <a href="/admin/products"
                        class="py-1 inline-block text-center px-3 border border-transparent rounded-md font-semibold hover:text-white text-xl uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                        X
                    </a>
                </div>
                <div class="p-6">
                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />
                    
                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    
                    <form method="POST" action="/admin/products" enctype="multipart/form-data">
                        @csrf
                        <div class="mt-4 flex w-full">
                            <div class="flex-1 pr-2">
                                <x-label for="name" :value="__('Name')" />
                        
                                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                                    autofocus />
                            </div>
                            <div class="flex-1 pl-2">
                                <x-label for="color" :value="__('Color')" />
                        
                                <x-input id="color" class="block mt-1 w-full" type="text" name="color" :value="old('color')" required
                                    autofocus />
                            </div>
                        </div>
                        <div class="mt-4 flex w-full">
                            <div class="flex-1 pr-2">
                                <x-label for="size" :value="__('Size')" />
                        
                                <x-input id="size" class="block mt-1 w-full" type="text" name="size" :value="old('size')" required
                                    autofocus />
                            </div>
                            <div class="flex-1 pl-2">
                                <x-label for="type" :value="__('Type')" />
                        
                                <x-input id="type" class="block mt-1 w-full" type="text" name="type" :value="old('type')" required
                                    autofocus />
                            </div>
                        </div>
                        <div class="mt-4">
                            <x-label for="price" :value="__('Price')" />
                        
                            <x-input id="price" class="block mt-1 w-full" type="number" min="1" step="0.01" name="price" :value="old('price')" required autofocus />
                        </div>
                        <div class="mt-4">
                            <x-label for="product_image" :value="__('Product Image')" />
                            
                            <input class="mt-1" type="file" name="product_image" id="product_image" required>
                        
                            {{-- <x-input id="image" class="block mt-1 w-full" type="text" name="image" :value="old('image')" required autofocus /> --}}
                        </div>
                    
                        <div class="flex items-center justify-end mt-4">
                            {{-- @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                            @endif --}}
                            <x-button class="ml-3">
                                {{ __('Add') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
    @if ($edit == 1)
    <div class="modal relative">
        <div class="modal-content bg-white shadow-lg pt-4">
            <div class="flex justify-between items center border-b border-gray-200 px-6 py-2">
                <p class="text-3xl">Edit Product</p>
                <a href="/admin/products"
                    class="py-1 inline-block text-center px-3 border border-transparent rounded-md font-semibold hover:text-white text-xl uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    X
                </a>
            </div>
            <div class="p-6">
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />
    
                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />
    
                <form class="inline" method="POST" action="/admin/products" enctype="multipart/form-data">
                    @csrf
                    
                    <input type="hidden" id="id" name="id" value="{{$product->id}}">
                    {{--HTML forms don't traditionally have PUT requests. This is a work-around to that--}}
                    @method('PUT')
                    <div class="mt-4 flex w-full">
                        <div class="flex-1 pr-2">
                            <x-label for="name" :value="__('Name')" />
        
                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{$product->name}}" required
                                autofocus />
                        </div>
                        <div class="flex-1 pl-2">
                            <x-label for="color" :value="__('Color')" />
                            
                            <x-input id="color" class="block mt-1 w-full" type="text" name="color" value="{{$product->color}}" required autofocus />
                        </div>
                    </div>
                    <div class="mt-4 flex w-full">
                        <div class="flex-1 pr-2">
                            <x-label for="size" :value="__('Size')" />
                        
                            <x-input id="size" class="block mt-1 w-full" type="text" name="size" value="{{$product->size}}" required autofocus />
                        </div>
                        <div class="flex-1 pl-2">
                            <x-label for="type" :value="__('Type')" />

                            <x-input id="type" class="block mt-1 w-full" type="text" name="type" value="{{$product->type}}" required autofocus />
                        </div>
                    </div>
                    <div class="mt-4 flex w-full">
                        <div class="flex-1 pr-2">
                            <x-label for="price" :value="__('Price')" />
        
                            <x-input id="price" class="block mt-1 w-full" type="number" min="1" step="0.01" name="price" value="{{$product->price}}"
                                required autofocus />
                        </div>
                        <div class="flex-1 pl-2">
                            <x-label for="stock" :value="__('Out Of Stock')" />

                            <select name="stock" id="stock" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required autofocus>
                                @if ($product->out_of_stock == 0)
                                    <option value="0" selected>No</option>
                                    <option value="1">Yes</option>
                                @else
                                    <option value="0">No</option>
                                    <option value="1" selected>Yes</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="mt-4">
                        <x-label for="product_image" :value="__('Reupload to replace current product image if required')" />
                        
                        <input class="mt-1" type="file" name="product_image" id="product_image" >
    
                    </div>
    
                    <div class="inline-block">
                        <x-button class="mt-4">
                            {{ __('Edit Product') }}
                        </x-button>
                    </div>
                </form>
                <form class="inline" method="POST" action="/admin/products">
                    @csrf
                    <input type="hidden" id="id" name="id" value="{{$product->id}}">
                    
                    {{--HTML forms don't traditionally have DELETE requests. This is a work-around to that--}}
                    @method("DELETE")
                    <div class="inline-block">
                        <x-button class="ml-4 mt-3 bg-red-700 hover:bg-red-600 active:bg-red-800 focus:border-red-800 ring-red-400">
                            {{ __('Delete') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
    <div class="px-8 mb-8 flex items-center justify-between">
        <p class="text-3xl">Products</p>
        <a href="/admin/products?add=1"
            class="py-2 inline-block text-center px-4 bg-gray-800 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
            Add
        </a>
    </div>
    @if (count($products) > 0)
        <div class="flex justify-start w-full flex-wrap">
            @foreach ($products as $item)
                <div class="admin-product-card shadow-lg bg-white">
                    <a href="/admin/products?id={{$item->id}}">
                        <div class="h-48 md:h-60 flex relative">
                            <img src="/storage/products_images/{{ $item->image }}"
                                alt="product image">
                        </div>
                        <div class="p-2">
                            <p class="text-2xl text-blue-600">{{$item->name}}</p>
                            <p class="text-xl">Type: {{$item->type}}</p>
                            <p class="text-xl">Color: {{$item->color}}</p>
                            <p class="text-xl">Size: {{$item->size}}</p>
                            <p class="text-xl text-blue-600">Price: £{{number_format(sprintf('%0.2f', preg_replace("/[^0-9.]/", "", $item->price)),2)}}</p>
                            <p class="text-xl">Out of Stock: 
                                <span class="font-bold {{$item->out_of_stock == 1 ? "text-red-500" : "text-green-500" }}">{{$item->out_of_stock == 1 ? "Yes" : "No" }}</span>
                            </p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center">
            <p class="text-3xl">No Product Yet</p>
        </div>
    @endif
</div>
@endsection