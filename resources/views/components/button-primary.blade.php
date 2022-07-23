@php
$tag = $attributes['href'] ? 'a' : 'button';
@endphp

<{{ $tag }}
    {{ $attributes->merge(['class' => 'inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-500 active:bg-primary-700 focus:outline-none focus:border-primary-700 focus:ring ring-primary-200 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</{{ $tag }}>
