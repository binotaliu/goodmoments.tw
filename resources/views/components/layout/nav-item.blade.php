@props(['active' => false])

<li
    {{ $attributes->except('class') }}
>
    <a
        {{
            $attributes
                ->only(['class', 'href'])
                ->class([
                    'inline-block',
                    'w-full md:w-auto',
                    'p-4',
                    $active ? 'bg-wood-500' : 'bg-wood-600',
                    'hover:bg-wood-500',
                    'text-white text-lg',
                    'transition-colors',
                ])
        }}
    >
        {{ $slot }}
    </a>
</li>
