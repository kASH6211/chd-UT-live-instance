@props(['disabled' => false])

<div class="border {{$disabled?'border-gray-400 border-dashed':'border-blue-100'}} mt-1">
    <input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'h-12 border-gray-500 border-0 text-gray-500 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 rounded-sm shadow-sm']) !!}>

</div>
