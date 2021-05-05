<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Shop') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-2xl">Order #{{ $order->id }}</h1>

            @if ($order->status == 'paid')
                <h2>Order paid!</h2>
            @else
                <h2>Order has status {{ $order->status }}</h2>
            @endif
        </div>
    </div>
</x-app-layout>
