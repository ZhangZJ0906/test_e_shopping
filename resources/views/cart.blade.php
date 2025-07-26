{{-- resources/views/cart/index.blade.php --}}
<div class="max-w-6xl mx-auto p-4">
    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
            data-tabs-toggle="#default-tab-content" role="tablist">
            <li class="me-2" role="presentation">
                <button
                    class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                    id="cart-tab" data-tabs-target="#cart" type="button" role="tab" aria-controls="cart"
                    aria-selected="true">
                    購物車
                </button>
            </li>
            <li class="me-2" role="presentation">
                <button
                    class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                    id="orders-tab" data-tabs-target="#orders" type="button" role="tab" aria-controls="orders"
                    aria-selected="false">
                    訂單狀況
                </button>
            </li>
            <li class="me-2" role="presentation">
                <button
                    class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                    id="history-tab" data-tabs-target="#history" type="button" role="tab" aria-controls="history"
                    aria-selected="false">
                    歷史訂單
                </button>
            </li>
        </ul>
    </div>

    <div id="default-tab-content">
        {{-- 購物車 Tab --}}
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="cart" role="tabpanel"
            aria-labelledby="cart-tab">
            <h2 class="text-2xl font-bold mb-4">我的購物車</h2>
            @if (isset($cartItems) && $cartItems->count() > 0)
                <form method="POST" action="{{ route('checkout') }}">
                    @csrf
                    <div class="space-y-4">
                        @foreach ($cartItems as $item)
                            <div class="bg-white rounded-lg shadow p-4 flex items-center justify-between">
                                <input type="checkbox" name="selected_items[]" value="{{ $item->id }}"
                                    class="cart-checkbox mr-4 w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                    data-subtotal="{{ $item->product->price * $item->quantity }}">
                                <div class="flex-1">
                                    <h4 class="text-lg font-semibold">{{ $item->product->name }}</h4>
                                    <p class="text-gray-600">單價：NT$ {{ number_format($item->product->price) }}</p>
                                    <div class="flex items-center mt-2">
                                        {{-- 減少 --}}
                                        <form method="POST" action="{{ route('cart.update', $item->id) }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="change" value="-1">
                                            <button type="submit"
                                                class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">-</button>
                                        </form>

                                        <span class="mx-3 font-medium">{{ $item->quantity }}</span>

                                        {{-- 增加 --}}
                                        <form method="POST" action="{{ route('cart.update', $item->id) }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="change" value="1">
                                            <button type="submit"
                                                class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">+</button>
                                        </form>
                                    </div>
                                    <p class="text-lg font-bold mt-2">小計：NT$
                                        {{ number_format($item->product->price * $item->quantity) }}</p>
                                </div>
                                <button onclick="removeItem({{ $item->id }})"
                                    class="ml-4 px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                                    移除
                                </button>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-6 bg-white rounded-lg shadow p-4">
                        <div class="text-right">
                            <h3 class="text-2xl font-bold mb-4">總金額：NT$
                                {{ number_format($cartItems->sum(function ($item) {return $item->product->price * $item->quantity;})) }}
                            </h3>
                            <button onclick="checkout()"
                                class="px-6 py-3 bg-green-500 text-white rounded-lg hover:bg-green-600 text-lg font-semibold">
                                結帳
                            </button>
                        </div>
                    </div>
                @else
                    <div class="text-center py-12">
                        <p class="text-gray-500 text-xl">購物車是空的</p>
                    </div>
            @endif
        </div>

        {{-- 訂單狀況 Tab --}}
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="orders" role="tabpanel"
            aria-labelledby="orders-tab">
            <h2 class="text-2xl font-bold mb-4">訂單狀況</h2>
            @if (isset($pendingOrders) && $pendingOrders->count() > 0)
                <div class="space-y-4">
                    @foreach ($pendingOrders as $order)
                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-xl font-bold">訂單 #{{ $order->id }}</h3>
                                @php
                                    $statusClass = match ($order->status) {
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'processing' => 'bg-blue-100 text-blue-800',
                                        'shipped' => 'bg-purple-100 text-purple-800',
                                        'completed' => 'bg-green-100 text-green-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                        default => 'bg-gray-100 text-gray-800',
                                    };
                                @endphp
                                <span class="px-3 py-1 rounded-full text-sm font-medium {{ $statusClass }}">
                                    {{ $order->status_text ?? $order->status }}
                                </span>
                            </div>

                            <p class="text-gray-600 mb-2">訂單日期：{{ $order->created_at->format('Y-m-d H:i') }}</p>
                            <p class="text-lg font-semibold mb-4">訂單總價：NT$ {{ number_format($order->total_price) }}</p>

                            <div class="border-t pt-4">
                                <h4 class="font-semibold mb-2">訂單商品：</h4>
                                @foreach ($order->orderItems as $item)
                                    <div class="flex justify-between items-center py-2 border-b last:border-b-0">
                                        <span class="flex-1">{{ $item->product->name }}</span>
                                        <span class="mx-4">x{{ $item->quantity }}</span>
                                        <span class="font-medium">NT$
                                            {{ number_format($item->product->price * $item->quantity) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-gray-500 text-xl">目前沒有進行中的訂單</p>
                </div>
            @endif
        </div>

        {{-- 歷史訂單 Tab --}}
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="history" role="tabpanel"
            aria-labelledby="history-tab">
            <h2 class="text-2xl font-bold mb-4">歷史訂單</h2>
            @if (isset($orders) && $orders->count() > 0)
                <div class="space-y-4">
                    @foreach ($orders as $order)
                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-xl font-bold">訂單 #{{ $order->id }}</h3>
                                @php
                                    $statusClass = match ($order->status) {
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'processing' => 'bg-blue-100 text-blue-800',
                                        'shipped' => 'bg-purple-100 text-purple-800',
                                        'completed' => 'bg-green-100 text-green-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                        default => 'bg-gray-100 text-gray-800',
                                    };
                                @endphp
                                <span class="px-3 py-1 rounded-full text-sm font-medium {{ $statusClass }}">
                                    {{ $order->status_text ?? $order->status }}
                                </span>
                            </div>

                            <p class="text-gray-600 mb-2">訂單日期：{{ $order->created_at->format('Y-m-d H:i') }}</p>
                            <p class="text-lg font-semibold mb-4">訂單總價：NT$ {{ number_format($order->total_price) }}
                            </p>

                            <div class="border-t pt-4">
                                <h4 class="font-semibold mb-2">訂單商品：</h4>
                                @foreach ($order->orderItems as $item)
                                    <div class="flex justify-between items-center py-2 border-b last:border-b-0">
                                        <span class="flex-1 text-left">名稱：{{ $item->product->name }}</span>
                                        <span class="flex-1 text-left"><img
                                                src="{{ $item->product->image ? asset('storage/' . $item->product->image) : asset('images/default.png') }}"
                                                alt="123"></span>
                                        <span class="flex-1 text-left">單價：{{ $item->product->price }}</span>
                                        <span class="mx-2 mr-5  min-w-[80px]">數量：{{ $item->quantity }}</span>
                                        <span class="font-medium text-right min-w-[120px]">總價錢：
                                            NT$ {{ number_format($item->product->price * $item->quantity) }}
                                        </span>
                                        <hr />
                                    </div>
                                @endforeach
                            </div>

                            {{-- @if ($order->status === 'completed')
                                <div class="mt-4 text-right">
                                    <button onclick="reorder({{ $order->id }})"
                                        class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                        再次購買
                                    </button>
                                </div>
                            @endif --}}
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-gray-500 text-xl">尚無歷史訂單</p>
                </div>
            @endif
        </div>
    </div>
</div>

@vite('resources/js/cart.js')
