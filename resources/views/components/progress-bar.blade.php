@props(['percentage', 'label' => null, 'thick' => false])

<div class="progress">
    @if ($label)
        <div class="progress__meta">
            <span>{{ $label }}</span>
            <span>{{ $percentage }}%</span>
        </div>
    @endif

    <div @class(['progress__track', 'progress__track--thick' => $thick])>
        <div class="progress__fill" style="width: {{ $percentage }}%"></div>
    </div>
</div>
