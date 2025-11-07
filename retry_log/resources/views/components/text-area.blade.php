@props([
    'name',
    'value' => '',
    'placeholder' => '',
])

<textarea
    name="{{ $name }}"
    id="{{ $name }}"
    {{ $attributes->merge([
        'class' => 'block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50',
        'placeholder' => $placeholder,
    ]) }}
>{{ old($name, $value) }}</textarea>
