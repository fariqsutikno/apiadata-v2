@props([
    'label' => null,
    'name' => '',
    'required' => false,
])

<div class="space-y-4 my-4">
    <div class="relative">
        <label class="text-sm mb-1">
            {{ $label }}
            @if($required) 
                <span class="text-red-500">*</span> 
            @endif
        </label>
        <select class="w-full px-4 py-2 mt-1 rounded-xl border focus:outline-none focus:ring-2 focus:ring-primary outline-none transition-all appearance-none {{ $required ? 'required' : ''}}" name="{{ $name }}" id="{{ $name }}">
            {{ $slot }}
        </select>
    </div>
</div>