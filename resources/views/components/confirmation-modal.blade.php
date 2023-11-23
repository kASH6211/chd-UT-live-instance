@props(['id' => null, 'maxWidth' => null])

<x-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
        <div class="sm:flex sm:items-start">
            
            <div class="shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-800/90 sm:mx-0 sm:h-10 sm:w-10">
                {{$icon}}
            </div>
            

            <div class="mt-5 w-full pr-10  sm:mt-0 sm:ml-4 sm:text-left">
                <h3 class="text-lg font-medium text-gray-900 mb-3">
                    {{ $title }}
                </h3>
                <hr/>

                <div class="mt-4 text-sm text-gray-600">
                    {{ $content }}
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-row justify-end px-6 py-4 bg-gray-100 text-right">
        {{ $footer }}
    </div>
</x-modal>
