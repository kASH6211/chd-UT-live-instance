   <div {{ $attributes->merge(['class' => 'flex justify-between']) }}>
        <div>
            <h4 {{ $attributes->merge(['class' => 'text-gray-500  tracking-widest uppercase text-sm']) }}>{{$slot}}</h4>
        </div>
    </div>