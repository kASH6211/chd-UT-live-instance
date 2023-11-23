@if ($errors->any())
<div class="mb-4 border-2 border-dashed border-red-600 p-2 bg-red-50 rounded-md" {{ $attributes }}>
    <div class=" font-medium text-red-600">{{ __('Something went wrong.') }}</div>

    <ul class="mt-3 list-disc list-inside text-sm text-red-600">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
