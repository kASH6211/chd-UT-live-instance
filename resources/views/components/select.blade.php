@props(['disabled' => false])


<div class="border bg-white py-1 {{$disabled?'border-gray-400 border-dashed':'border-blue-100'}} mt-1">

    <select class="border-0 focus:ring-0 w-full form-select" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'text-gray-500 focus:border-blue-100 focus:ring focus:ring-blue-100 focus:ring-opacity-50 rounded-sm shadow-sm']) !!}>


        <option value="">Select Option</option>

        @foreach ($ddlist as $item)

        <option class="border-0 border-purple-100 leading-loose" value={{$item[$idfield]}}>{{$item[$textfield]}}</option>

        @endforeach

    </select>

</div>
