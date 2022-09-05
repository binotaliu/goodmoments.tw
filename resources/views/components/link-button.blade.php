@props(['size' => 'DEFAULT', 'theme' => 'DEFAULT'])
@php
$attributes = $attributes
    ->class([
        ...(match ($size) {
            default => ['px-4 py-2'],
            'lg' => ['px-6 py-3'],
        }),
        'border',
        'text-center',
        ...(match ($theme) {
            default => [
                'text-pearl-900',
                'border-pearl-500 bg-white hover:bg-pearl-100',
            ],
            'primary' => [
                'text-white',
                'border-wood-500 bg-wood-500 hover:bg-wood-400',
            ],
        }),
        'transition-colors',
    ])
@endphp

<x-external-link {{ $attributes }}>
    {{ $slot }}
</x-external-link>
