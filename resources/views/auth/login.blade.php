<x-guest-layout>
    <div class="flex max-w-7xl min-h-[calc(100vh-21rem)] mx-auto py-6 px-4 sm:px-6 lg:px-8  rounded-md justify-center items-center">


        {{-- <div class="w-1/2 min-h-[calc(100vh-12rem)] ">
            <img src="/assets/images/illustration5.png" />
        </div> --}}
        <div class="w-full h-full  flex  items-center py-12 pb-20 ">
            <div class="w-1/2 flex flex-col items-center bg-white">
                {{-- <div class="p-4 bg-blue-900/30 rounded-full mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-16 h-16 fill-white">
                        <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z" clip-rule="evenodd" />
                    </svg>
                </div> --}}



{{-- 
                <h1 class="text-4xl font-inter">Welcome back,</h1>
                <h2 class="text-xl font-inter text-gray-700 mt-2">Access your personalized dashboard and features</h2>
                <p class="text-center mt-4 text-gray-500">Sign in to your account to manage your settings, view your profile, and access exclusive features. We're delighted to have you back!</p> --}}
                <x-login-page-office-name/>
                



            </div>
            <div class="w-1/2 flex flex-col items-center border-l p-10 rounded-md border-gray-200 bg-gray-100">

                {{-- <img src="./assets/images/permission.jpg" class="w-40" /> --}}
                <h1 class="mb-5 text-gray-800 text-xl font-inter">Member Login</h1>
                <x-authentication-card>
                    <x-slot name="logo">
                        {{-- <x-authentication-card-logo /> --}}
                    </x-slot>


                    @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div>
                            <x-label for="userid" value="{{ __('User Id') }}" />
                            <x-input id="userid" class="block mt-1 w-full" type="text" name="userid" :value="old('user_id')" required autofocus />
                        </div>

                        <div class="mt-4">
                            <x-label for="password" value="{{ __('Password') }}" />
                            <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                        </div>

                        <div class="block mt-4">
                            <label for="remember_me" class="flex items-center">
                                <x-checkbox id="remember_me" name="remember" />
                                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                            @endif

                            <x-button class="ml-4">
                                {{ __('Log in') }}
                            </x-button>
                        </div>
                    </form>
                </x-authentication-card>


                <div class="flex-1  flex flex-col justify-center items-center">

                    <x-validation-errors class="mb-4 bg-red-400" />

                </div>

            </div>


        </div>
        

    </div>
    <nav x-data="{ open: false }" class="bg-gray-800">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 ">
                {{-- <div class="flex justify-start  w-80 items-center">
                    <h1 class="text-sm uppercase font-semibold text-white">Nextgen DISE CAPSULE</h1>
                </div> --}}
                <div class=" w-full flex justify-center">
                    <!-- Navigation Links-->
            <div class="hidden space-x-8 sm:-my-px sm:flex">
                <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" class="!text-gray-400 hover:!text-white ">
                    {{ __('Contact Us') }}
                </x-nav-link> 

                <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" class="!text-gray-400 hover:!text-white">
                    {{ __('Help') }}
                </x-nav-link> 

                <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" class="!text-gray-400 hover:!text-white">
                    {{ __('Policies') }}
                </x-nav-link> 
                </div>
               
        </div>
    </nav>
    <div class="bg-gray-800 flex flex-col justify-center items-center p-4 text-gray-600 border-t border-dashed border-gray-600">
       
        <p><x-configuration.login-page-footer-text/></p>
        <p>Designed & Developed by National Informatics Centre,</p>
        <p>Ministry of Electronics and Information Technology, Government of India</p>


    </div>
</x-guest-layout>
