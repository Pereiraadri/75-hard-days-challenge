@props(['percentage' => 0, 'size' => 64, 'radius' => 26, 'strokeWidth' => 4, 'gradientId' => 'score-ring-gradient'])

@php($circumference = 2 * M_PI * $radius)

<svg class="score-ring" width="{{ $size }}" height="{{ $size }}" viewBox="0 0 {{ $size }} {{ $size }}" aria-hidden="true">
    <circle
        class="score-ring__track"
        cx="{{ $size / 2 }}"
        cy="{{ $size / 2 }}"
        r="{{ $radius }}"
        fill="none"
        stroke-width="{{ $strokeWidth }}"
    />
    <circle
        class="score-ring__value"
        cx="{{ $size / 2 }}"
        cy="{{ $size / 2 }}"
        r="{{ $radius }}"
        fill="none"
        stroke="url(#{{ $gradientId }})"
        stroke-width="{{ $strokeWidth }}"
        stroke-linecap="round"
        stroke-dasharray="{{ $circumference }}"
        stroke-dashoffset="{{ $circumference - ($percentage / 100) * $circumference }}"
        data-score-ring
        data-radius="{{ $radius }}"
    />
    <defs>
        <linearGradient id="{{ $gradientId }}" x1="0%" y1="0%" x2="100%" y2="0%">
            <stop class="score-ring__gradient-start" offset="0%"/>
            <stop class="score-ring__gradient-end" offset="100%"/>
        </linearGradient>
    </defs>
</svg>
