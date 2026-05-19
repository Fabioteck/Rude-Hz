@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-bold text-sm text-gray-300 uppercase tracking-widest mb-1']) }}>
    {{ $value ?? $slot }}
</label>
