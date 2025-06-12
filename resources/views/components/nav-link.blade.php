@props(['active'])

@php
$classes = ($active ?? false)
    ? 'block px-4 py-2 rounded-lg  text-blue-700 font-medium transition duration-200 ease-in-out'
    : 'block px-4 py-2 rounded-lg text-gray-300  hover:text-white transition duration-200 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
