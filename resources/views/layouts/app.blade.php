<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>



    <!-- Styles -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.0/flowbite.min.css" rel="stylesheet" />

    @livewireStyles

    @stack('styles')

</head>
<body class="font-sans antialiased">
 {{--  <div id="google_translate_element" class="w-full"></div>
   <script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
}
</script>

<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script> --}}
    <x-banner/>

    <div class="min-h-screen bg-gray-100">

        <!-- Page Heading -->


        <!-- Page Content -->
        <div class="flex">
            <main class="w-full">
             
                @livewire('navigation-menu')
                @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
                @endif




                {{ $slot }}
            </main>
        </div>
    </div>
    <div class="bg-gray-800 h-36 flex flex-col items-center justify-center text-gray-400 text-sm">

        <p><x-configuration.login-page-footer-text/></p>
        
        <div class="pt-1">Designed & Developed by National Informatics Centre,</div>
        
            <div class="py-1">Ministry of Electronics and Information Technology, Government of India</div>
        </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.0/flowbite.min.js"></script>


    @stack('modals')

    @livewireScripts





</body>
</html>
