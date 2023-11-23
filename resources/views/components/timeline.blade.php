<div>
    <script src="/assets/js/lottieplayer.js"></script>


    @if($history->count()<=1) <div class="flex flex-col justify-center items-center h-96">
        <div>
            <lottie-player src="/assets/js/lottieanimations/empty-ghost.json" background="transparent" speed="1" style="width: 300px; height: 300px;" loop autoplay></lottie-player>

        </div>
        <x-sub-title class="font-semibold text-gray-400 mb-2">Project Manual Timeline not yet created ! Please have some patience.</x-sub-title>
        <a href="/project/{{$projectid}}">
            <x-secondary-button>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 9l-3 3m0 0l3 3m-3-3h7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>




                return back</x-secondary-button>
        </a>

</div>
@else
<ol class="relative border-l-2 border-gray-200">
    @foreach($history as $record)
    <li class="mb-10 ml-6">
        @switch($record->action_performed)
        @case("CREATED")

        <span class="absolute flex items-center justify-center w-12 h-12 text-white bg-fuchsia-700  rounded-full -left-6 ring-2 ring-fuchsia-900 dark:ring-gray-900 dark:bg-blue-900">
            {{$record->id}}
        </span>
        <div class="items-center ml-4 justify-between p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:flex dark:bg-gray-700 dark:border-gray-600">
            <time class="mb-1 text-xs font-normal text-gray-400 sm:order-last sm:mb-0">just now</time>
            <x-sub-title>
                <div>{{$record->fromUser->name}} <span class="font-semibold text-fuchsia-700" class="font-semibold text-">{{$record->action_performed}}</span></span> a Project titled <span class="font-semi-bold bg-gray-200 text-gray-500 px-2 rounded">{{$record->project->title}}</span> </div>
            </x-sub-title>
        </div>

        @break
        @case("SUBMITTED")
        <span class="absolute flex items-center justify-center w-12 h-12 text-white bg-blue-700 rounded-full -left-6 ring-2 ring-blue-900 dark:ring-gray-900 dark:bg-blue-900">
            {{$record->id}}
        </span>
        <div class="items-center ml-4 justify-between p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:flex dark:bg-gray-700 dark:border-gray-600">
            <time class="mb-1 text-xs font-normal text-gray-400 sm:order-last sm:mb-0">just now</time>
            <x-sub-title>
                <div>{{$record->fromUser->name}} <span class="font-semibold text-blue-700">{{$record->action_performed}}</span> the Project to <span class="font-semi-bold bg-gray-200 text-gray-500 px-2 rounded">{{$record->toUser->name}}</span> for approval </div>
            </x-sub-title>
        </div>
        @break
        @case("REJECTED")
        <span class="absolute flex items-center justify-center w-12 h-12 text-white bg-rose-700 rounded-full -left-6 ring-2 ring-rose-900 dark:ring-gray-900 dark:bg-blue-900">
            {{$record->id}}
        </span>
        <div class="items-center ml-4 justify-between p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:flex dark:bg-gray-700 dark:border-gray-600">
            <time class="mb-1 text-xs font-normal text-gray-400 sm:order-last sm:mb-0">just now</time>
            <x-sub-title>
                <div>{{$record->fromUser->name}} <span class="font-semibold text-rose-700">{{$record->action_performed}}</span> the Project and send back to <span class="font-semi-bold bg-gray-200 text-gray-500 px-2 rounded">{{$record->toUser->name}}</span> by recommending some changes. </div>
            </x-sub-title>
        </div>
        @break
        @case("APPROVED")
        <span class="absolute flex items-center justify-center w-12 h-12 text-white bg-lime-700 rounded-full -left-6 ring-2 ring-lime-900 dark:ring-gray-900 dark:bg-blue-900">
            {{$record->id}}
        </span>
        <div class="items-center ml-4 justify-between p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:flex dark:bg-gray-700 dark:border-gray-600">
            <time class="mb-1 text-xs font-normal text-gray-400 sm:order-last sm:mb-0">just now</time>
            <x-sub-title>
                <div>{{$record->fromUser->name}} <span class="font-semibold text-lime-700">{{$record->action_performed}}</span> the Project and forward to <span class="font-semi-bold bg-gray-200 text-gray-500 px-2 rounded">{{$record->toUser->name}}</span> for approval </div>
            </x-sub-title>
        </div>
        @break
        @case("PUBLISHED")
        <span class="absolute flex items-center justify-center w-12 h-12 text-white bg-green-700 rounded-full -left-6 ring-2 ring-green-900 dark:ring-gray-900 dark:bg-blue-900">
            {{$record->id}}
        </span>
        <div class="items-center ml-4 justify-between p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:flex dark:bg-gray-700 dark:border-gray-600">
            <time class="mb-1 text-xs font-normal text-gray-400 sm:order-last sm:mb-0">just now</time>
            <x-sub-title>
                <div>{{$record->fromUser->name}} approved and <span class="font-semibold text-green-700">{{$record->action_performed}}</span> the Project in Public Domain. </div>
            </x-sub-title>
        </div>
        @break
        @default

        @endswitch


    </li>
    @endforeach


</ol>
<div class="flex justify-center items-center"><a href="/project/{{$projectid}}">
        <x-dark-button>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 9l-3 3m0 0l3 3m-3-3h7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>




            return back</x-dark-button>
    </a></div>



@endif

</div>
