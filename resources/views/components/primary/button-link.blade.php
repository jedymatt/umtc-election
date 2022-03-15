<a {{ $attributes->merge(['class' => 'inline-flex items-center px-4 py-2 bg-primary-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 active:bg-primary-500 focus:outline-none focus:border-primary-500 focus:ring ring-primary-200 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</a>
