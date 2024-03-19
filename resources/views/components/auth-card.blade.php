<div class="min-h-screen flex flex-col justify-center sm:justify-center items-center bg-black bg-opacity-50">
    <div>
        {{ $logo }}
    </div>

    <div class="w-full sm:max-w-md px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>
</div>
