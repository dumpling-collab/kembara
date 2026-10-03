@props(['size' => 'md'])

@php
    $sizes = ['sm' => 'h-12 w-12', 'md' => 'h-16 w-16', 'lg' => 'h-20 w-20'];
@endphp

<svg viewBox="0 0 100 100" {{ $attributes->class([$sizes[$size] ?? $sizes['md'], 'flex-shrink-0']) }}>
    <path d="M 50.0,2.0 L 62.36,11.96 L 78.21,11.17 L 82.36,26.49 L 95.65,35.17 L 90.0,50.0 L 95.65,64.83 L 82.36,73.51 L 78.21,88.83 L 62.36,88.04 L 50.0,98.0 L 37.64,88.04 L 21.79,88.83 L 17.64,73.51 L 4.35,64.83 L 10.0,50.0 L 4.35,35.17 L 17.64,26.49 L 21.79,11.17 L 37.64,11.96 Z"
          fill="#183178" />
    <text x="50" y="55" text-anchor="middle" fill="#ff8400" font-size="17" font-weight="800" font-family="inherit">kembara</text>
</svg>
