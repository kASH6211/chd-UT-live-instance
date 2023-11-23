<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- Styles -->


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="font-sans text-gray-900 antialiased">
        <div class="flex  justify-center items-center bg-white">
            <div class="w-2/3 p-8 pb-3 flex items-center " >
                {{-- UPDATED --}}
                <img src="./assets/images/logo.jpeg" class="h-16 w-22 rounded-md"/><h1 class="text-2xl font-semibold ml-6 font-inter text-blue-900">District Information System for Elections<br/><span class="text-red-700">NextGen DISE</span></h1></div>
        </div>
        <nav x-data="{ open: false }" class="bg-blue-900 border-b border-gray-100">
            <!-- Primary Navigation Menu -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 ">
                    {{-- <div class="flex justify-start  w-80 items-center">
                        <h1 class="text-sm uppercase font-semibold text-white">Nextgen DISE CAPSULE</h1>
                    </div> --}}
                    <div class=" w-full flex justify-end">
                        <!-- Navigation Links-->
                <div class="hidden space-x-8 sm:-my-px sm:flex">
                    <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" class="!text-white  hover:bg-blue-600">
                        {{ __('Home') }}
                    </x-nav-link> 

                    <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" class="!text-white w-52 hover:bg-blue-600">
                        {{ __('Polling Personnel Management') }}
                    </x-nav-link> 

                    <x-nav-link target="_blank" href="https://ppdms.punjab.gov.in" :active="request()->routeIs('dashboard')" class="!text-white w-96 hover:bg-blue-600">
                        {{ __('Election Activity Monitoring (Poll Day & Counting Day)') }}
                    </x-nav-link> 
                     
                    </div>
                    <div class=" w-full flex justify-end">
                        <!-- Navigation Links-->
                        <x-nav-link href="{{ route('login') }}" :active="request()->routeIs('dashboard')" class="!text-white ">
                            {{ __('Login') }}
                        </x-nav-link> 
                </div>
            </div>
        </nav>
        {{ $slot }}
    </div>
</body>
</html>
