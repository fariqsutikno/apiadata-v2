@props([
    'label' => null,
    'placeholder' => '',
    'name' => '',
    'value' => '',
    'type' => 'text',
    'required' => false,
    'disabled' => false,
    'icon' => null  // tambahkan default value null
])

<div class="{{ $icon ? 'relative' : '' }} mb-4"> <!-- Menambahkan margin bawah untuk jarak antar elemen -->
    @if ($label)
        <label for="{{ $name }}" class="text-black text-sm mb-1">
            {{ $label }} 
            
            @if($required) 
                <span class="text-red-500">*</span> 
            @endif
        </label>
    @endif
    <input 
        placeholder="{{ $placeholder }}"
        id="{{ $name }}" 
        name="{{ $name }}" 
        type="{{ $type }}" 
        value="{{ $value }}"
        class="w-full {{ $disabled ? 'text-gray-500' : 'text-black'}} font-medium rounded-xl py-2 px-4 {{ $icon ? 'pl-12' : '' }} mt-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary"
        {{ $disabled ? 'disabled' : ''}} {{ $required ? 'required' : ''}} 
    >
    @if ($icon)
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400 absolute left-3 top-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}" />
        </svg>
    @endif
    
    {{ $slot }}
</div>