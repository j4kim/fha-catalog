@props(['link-component'])

@php
$links = [
    [
        'href' => route('dashboard'),
        'active' => request()->routeIs('dashboard'),
        'content' => __('Dashboard'),
    ],
    [
        'href' => route('funds.index'),
        'active' => request()->is('funds*'),
        'content' => __('Funds'),
    ],
];
@endphp


<div {{ $attributes }} >
    @foreach ($links as $link)
        <x-dynamic-component
            :component="$linkComponent"
            :href="$link['href']"
            :active="$link['active']"
            wire:navigate
        >
            {{ $link['content'] }}
        </x-dynamic-component>
    @endforeach
</div>