@props(['active'])

@php
$classes = ($active ?? false)
    ? 'block px-4 py-2 rounded-lg bg-gray-700 text-white font-medium transition duration-200 ease-in-out'
    : 'block px-4 py-2 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition duration-200 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
