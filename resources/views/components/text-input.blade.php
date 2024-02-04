@props(['disabled' => false])

@php
    $errorClass = $errors->has($attributes['id']) ? 'is-invalid' : '';
@endphp

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'form-control ' . $errorClass]) !!}>
