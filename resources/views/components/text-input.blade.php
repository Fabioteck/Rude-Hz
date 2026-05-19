@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'bg-[#0a0a0a] border-gray-800 text-white font-bold placeholder-gray-500 focus:border-[#d9ff00] focus:ring-[#d9ff00] rounded-md shadow-sm w-full py-3']) !!}>
