 <div {{ $attributes->merge(['class' => 'flex justify-between']) }}>
        <div>
            <h2 {{ $attributes->merge(['class' => 'text-gray-800 font-semibold tracking-widest uppercase text-md']) }}>{{$slot}}</h2>
        </div>
    </div>