   @if (Route::has('login'))
   <div class="fixed top-0 right-0 hidden px-6 py-4 sm:block">
       @auth
       <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 underline dark:text-gray-500">Dashboard</a>
       @else
       <a href="{{ route('login') }}" class="text-sm text-white dark:text-gray-500">Log in</a>

       @if (Route::has('register'))
       <a href="{{ route('register') }}" class="ml-4 text-sm text-white  dark:text-gray-500">Register</a>
       @endif
       @endauth
   </div>
   @endif

   <div class="flex flex-col bg-zinc-100 w-full items-center">
       <div class="z-1 flex h-14 w-full items-center justify-center px-0">
           <div class="w-8/12 py-5">
               <nav class=" pr-2 py-0.5 opacity-90 dark:bg-gray-900 sm:pr-4">
                   <div class="container mx-auto flex flex-wrap items-center justify-between">
                       <a href="https://flowbite.com/" class="flex items-center">
                           <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-3 h-6 w-6 text-white sm:h-9">
                               <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z" />
                           </svg>
                           <span class="self-center whitespace-nowrap text-lg font-semibold text-white">Project
                               Manual Repository</span>
                       </a>
                       <button data-collapse-toggle="navbar-default" type="button" class="ml-3 inline-flex items-center rounded-lg p-2 text-sm text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600 md:hidden" aria-controls="navbar-default" aria-expanded="false">
                           <span class="sr-only">Open main menu</span>
                           <svg class="h-6 w-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                               <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                           </svg>
                       </button>
                       <div class="hidden w-full md:block md:w-auto" id="navbar-default">
                           <ul class="mt-4 flex flex-col p-4 dark:border-gray-700 dark:bg-gray-800 md:mt-0 md:flex-row md:space-x-0 md:border-0">
                               <li class="hover:bg-rose-700 block rounded py-2 pl-3 pr-4">

                                   <a href="/" class="{{ Route::is('home') ? 'md:text-rose-400' : '' }} text-sm text-white dark:text-white md:bg-transparent md:p-0 ">Home</a>
                               </li>
                               <li class="hover:bg-rose-700 block rounded py-2 pl-3 pr-3">

                                   <a href="/projects" class="{{ Route::is('projects') ? 'md:text-orange-400' : '' }} text-sm   text-white dark:text-white md:bg-transparent md:p-0 ">Projects</a>

                               </li>


                               <li class="hover:bg-rose-700 block rounded py-2 pl-3 pr-4">

                                   <a href="/" class="{{ Route::is('home') ? 'md:text-orange-400' : '' }} text-sm  text-white dark:text-white md:bg-transparent md:p-0 ">About PMR</a>

                               </li>

                               <li class="hover:bg-rose-700 block rounded py-2 pl-3 pr-4">

                                   <a href="/" class="{{ Route::is('home') ? 'md:text-orange-400' : '' }} text-sm  text-white dark:text-white md:bg-transparent md:p-0 ">PMR Manual</a>

                               </li>

                               <li class="hover:bg-rose-700 block rounded py-2 pl-3 pr-4">

                                   <a href="/" class="{{ Route::is('home') ? 'md:text-orange-400' : '' }} text-sm  text-white dark:text-white md:bg-transparent md:p-0 ">Contact Us</a>

                               </li>

                           </ul>
                       </div>
                   </div>
               </nav>
           </div>
       </div>
   </div>
