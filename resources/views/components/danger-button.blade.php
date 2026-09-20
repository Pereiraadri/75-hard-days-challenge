<button {{ $attributes->merge(['type' => 'submit', 'class' => 'button button--danger button--inline']) }}>
    {{ $slot }}
</button>
