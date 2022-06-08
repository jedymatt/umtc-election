<button {{ $attributes->merge(['class' => 'p-2 bg-primary font-medium rounded-md hover:bg-primary-800 focus:ring text-white text-sm ring-primary-200 focus:bg-primary-700'])}}>
    {{ $slot }}
</button>
