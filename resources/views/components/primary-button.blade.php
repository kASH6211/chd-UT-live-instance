<button {{ $attributes->merge(['class' => 'inline-flex items-center justify-center px-4 py-4 bg-blue-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:border-blue-800 focus:ring focus:ring-blue-200 active:bg-fuchsia-900 disabled:opacity-25 transition']) }}>
    {{ $slot }}
</button>
