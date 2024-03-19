@extends('layouts.admin')

@section('content')
    <div class="mt-40 px-10">
        <div class="text-center">
            <p class="text-3xl">Admin Section</p>
        </div>
        <div class="flex flex-col md:flex-row md:justify-evenly items-center mt-20">
            <a href="{{ route('admin.products') }}" class="w-3/4 md:w-1/4 my-8 py-6 inline-block text-center px-4 bg-gray-800 border border-transparent rounded-md font-semibold text-base text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                Products
            </a>
            <a  href="{{ route('admin.orders') }}"
                class="w-3/4 md:w-1/4 my-8 py-6 inline-block text-center px-4 bg-gray-800 border border-transparent rounded-md font-semibold text-base text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                Orders
            </a>
            <a  href="{{route('admin.customer')}}"
                class="w-3/4 md:w-1/4 my-8 py-6 inline-block text-center px-4 bg-gray-800 border border-transparent rounded-md font-semibold text-base text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                Customers
            </a>
        </div>
    </div>
@endsection