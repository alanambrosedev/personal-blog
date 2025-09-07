@props([
    'id' => null,
    'name',
    'options' => [],
    'selected' => null,
    'multiple' => false,
    'class' => '',
    'placeholder' => '',
])


<select id="{{ $id ?? $name }}" name="{{ $name }}{{ $multiple ? '[]' : '' }}"
    {{ $attributes->merge(['class' => $class]) }} @if ($multiple) multiple @endif>
    @if ($placeholder && !$multiple)
        <option value="">{{ $placeholder }}</option>
    @endif

    @foreach ($options as $option)
        <option value="{{ $option->id }}"
            @if ($multiple) {{ in_array($option->id, (array) $selected) ? 'selected' : '' }}
            @else
                {{ $selected == $option->id ? 'selected' : '' }} @endif>
            {{ $option->name }}
        </option>
    @endforeach
</select>
