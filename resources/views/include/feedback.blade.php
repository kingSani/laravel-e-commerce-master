
@if (session('message'))
    <div class="flex justify-center alert">
        <div class="px-16 py-4 bg-blue-700 bg-opacity-75 rounded">
            <p class="md:text-xl text-center text-white">{{session('message')}}</p>
        </div>
    </div>
@endif

@if (session('warning'))
<div class="flex justify-center alert">
    <div class="px-16 py-4 bg-red-700 bg-opacity-75 rounded">
        <p class="md:text-xl text-center text-white">{{session('warning')}}</p>
    </div>
</div>
@endif