<x-guest-layout>

    <x-auth-card>
        <x-slot name="logo">
            {{-- <a href="/">
                <img src="/images/app-logo.png" alt="" class="w-38 h-16">
            </a> --}}
            {{--<x-application-logo class="w-20 h-20 fill-current text-gray-500" /> --}}
        </x-slot>
<div class="flex flex-start items-center">
            <a href="{{route('products')}}" class="hover:underline">
                <p class="text-2xl text-blue-600">
                    Back to Store
                </p>
            </a>
        </div>

        <div class='text-center mb-12 mt-8 flex justify-center'>
            <a href="/" class='inline text-center mx-auto'>
                {{-- <x-application-logo class="w-20 h-20 fill-current text-gray-500" /> --}}
                <img src="/images/app-logo.svg" alt="" class="w-38 h-16">
            </a>
        </div>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />
      
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <input type="hidden" id="role" name="role" value="CUSTOMER">
            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>
            
            {{-- Forgot Password --}}
            <div class="mt-4">
                <a href="/forgot-password" class="hover:underline">
                    {{ __('Forgot password? Click here') }}
                </a>
            </div>

            <div class="flex items-center justify-end mt-4">
                {{-- @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif --}}

                <a href="/register" class="mx-4 hover:underline">
                    {{ __('No account? Register') }}
                </a>
                <x-button class="ml-3">
                    {{ __('Log in') }}
                </x-button>
            </div>

            <div class="flex items-center mt-4">
                <div class="h-1 flex-1 border-t border-gray-300"></div>
                <p class="text-gray-500 mx-4">OR</p>
                <div class="h-1 flex-1 border-t border-gray-300"></div>
            </div>
            {{-- Login with Facebook --}}
            <div class="flex items-center justify-end mt-4">
                <a class="btn" href="{{ url('auth/facebook') }}"
                    style="background: #3B5499; color: #ffffff; padding: 10px; width: 100%; text-align: center; display: block; border-radius:3px;">
                    Login with Facebook
                </a>
            </div>

            {{-- Login with GitHub --}}
            <div class="flex items-center justify-end mt-4">
                <a class="btn" href="{{ url('auth/github') }}"
                    style="background: #313131; color: #ffffff; padding: 10px; width: 100%; text-align: center; display: block; border-radius:3px;">
                    Login with GitHub
                </a>
            </div>
            <div class="flex items-center justify-end mt-4">
                <a class="btn" href="{{route('admin')}}"
                    style="background: #313131; color: #fff; padding: 10px; width: 100%; text-align: center; display: block; border-radius:3px;">
                    Login as admin
                </a>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
