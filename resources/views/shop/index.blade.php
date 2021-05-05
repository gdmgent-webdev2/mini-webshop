<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Shop') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <ul class="flex flex-wrap">
                <li class="btn mx-2 @if($slug == null) font-bold @endif">
                    <a href="{{ route('shop') }}">All</a>
                </li>
                @foreach($categories as $category)
                    <li class="btn mx-2 @if($category->slug == $slug) font-bold @endif">
                        <a href="{{ route('shop', $category->slug) }}" title="{{ $category->name }}">{{ $category->name }}</a>
                    </li>
                @endforeach
            </ul>

            @if($cart->hasItems())
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl">Cart</h2>
                    <table class="mt-2">
                        <tbody>
                        @foreach($cart->items as $item)
                            <tr>
                                <td class="p-2">{{ $item->quantity }}x</td>
                                <td class="p-2">{{ $item->name }}</td>
                                <td class="p-2 text-right">€ {{ $item->price / 100 }}</td>
                                <td class="p-2 text-right">€ {{ $item->getTotal() / 100 }}</td>
                            </tr>
                        @endforeach
                        <tr class="font-bold text-right">
                            <td colspan="2"></td>
                            <td class="p-2">
                                Total
                            </td>
                            <td class="p-2">
                                € {{ str_replace('.', ',', $cart->getTotal() / 100) }}
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <form method="post" action="{{ route('shop.order.create') }}">
                        @csrf
                        <x-button type="submit">Afrekenen</x-button>
                    </form>
                </div>
            </div>
            @endif


            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 bg-white border-b border-gray-200">

                    <table class="table-auto">
                        <thead class="text-left">
                            <tr>
                                <th class="font-normal" style="width: 20%">Name</th>
                                <th class="font-normal text-right" style="width: 20%">Price</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td class="py-2 font-bold">
                                        {{ $product->name }} <br />
                                        @foreach($product->tags as $tag)
                                            <span class="bg-gray-300 p-1 rounded-md text-xs">{{ $tag->name }}</span>
                                        @endforeach
                                    </td>
                                    <td class="py-2 text-right">€{{ str_replace('.', ',', ($product->price / 100)) }}</td>
                                    <td class="py-2 text-right">
                                        <form method="post" action="{{ route('shop.cart') }}">
                                            @csrf
                                            <input type="hidden" value="{{ $product->id }}" name="product_id" />
                                            <x-button type="submit">Buy</x-button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
