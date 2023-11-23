@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'py-1 bg-white', 'dropdownClasses' => '','nodropdown'=>''])

@php
switch ($align) {
case 'left':
$alignmentClasses = 'origin-top-left left-0';
break;
case 'top':
$alignmentClasses = 'origin-top';
break;
case 'none':
case 'false':
$alignmentClasses = '';
break;
case 'right':
default:
$alignmentClasses = 'origin-top-right right-0';
break;
}

switch ($width) {
case '48':
$width = 'w-48';
break;
case '64':
$width = 'w-64';
break;

}
@endphp

<div class="relative !space-x-0" x-data="{ open: false }" @click.away="open = false" @close.stop="open = false">
    @if($nodropdown=='')
    <div @click="open = ! open" class="flex justify-center items-center h-full">
        {{ $trigger }}
    </div>
    @else
    <div class="flex justify-center items-center h-full">
        {{ $trigger }}
    </div>


    @endif

    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute z-50 mt-2 {{$width}} rounded-md shadow-lg {{ $alignmentClasses }} {{ $dropdownClasses }}" style="display: none;" @click="open = false">
        <div class="rounded-md  ring-opacity-5 {{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>
