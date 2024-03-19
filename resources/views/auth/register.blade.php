<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            {{-- <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a> --}}
        </x-slot>

        <div class='text-center mb-12 mt-8 flex justify-center'>
            <a href="/" class='inline text-center mx-auto'>
                {{-- <x-application-logo class="w-20 h-20 fill-current text-gray-500" /> --}}
                <img src="/images/app-logo.png" alt="" class="w-38 h-16">
            </a>
        </div>
        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Name')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <div class="md:flex md:justify-between">
                <div class="mt-4 md:pr-1">
                    <x-label for="password" :value="__('Password')" />

                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                        autocomplete="new-password" />
                </div>
                <div class="mt-4 md:pl-1">
                    <x-label for="password_confirmation" :value="__('Confirm Password')" />

                    <x-input id="password_confirmation" class="block mt-1 w-full"
                                    type="password"
                                    name="password_confirmation" required />
                </div>
            </div>
            <!-- Password -->

            <!-- Confirm Password -->

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Register') }}
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
                    Continue with Facebook
                </a>
            </div>

            {{-- Login with GitHub --}}
            <div class="flex items-center justify-end mt-4">
                <a class="btn" href="{{ url('auth/github') }}"
                    style="background: #313131; color: #ffffff; padding: 10px; width: 100%; text-align: center; display: block; border-radius:3px;">
                    Continue with GitHub
                </a>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
