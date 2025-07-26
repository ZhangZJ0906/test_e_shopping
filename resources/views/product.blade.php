<div class="container mx-auto py-16">
    <div class="flex flex-col md:flex-row justify-center items-center">
        <div class="flex bg-white rounded-3xl shadow-xl overflow-hidden w-full max-w-5xl">
            <!-- 左邊圖片大尺寸 -->
            <div class="flex items-center justify-center bg-gray-100 p-10 md:p-16">
                <img class="w-80 h-80 object-contain"
                    src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/default.png') }}"
                    alt="{{ $product->description }}">
            </div>
            <!-- 右邊資料內容更大字級 -->
            <div class="flex-1 p-12">
                <h1 class="text-5xl font-extrabold mb-12">商品資料</h1>
                <div class="space-y-7 text-xl">
                    <div><span class="font-semibold">商品名稱：</span>{{ $product->name }}</div>
                    <div><span class="font-semibold">商品價格：</span>{{ $product->price }}</div>
                    <div><span class="font-semibold">商品詳述：</span>{{ $product->description }}</div>
                    <div id="stock"><span class="font-semibold">商品庫存：</span>{{ $product->stock }}</div>
                </div>
                <form method="POST" action="{{ route('cart.add') }}" class="mt-12">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <label for="quantity" class="font-semibold text-lg ">買多少</label>
                    <input type="number" name="quantity" value="1" id="quantity"> {{-- 可動態調整數量 --}}

                    <div class="mt-12 pt-10 border-t border-gray-200 flex justify-end">
                        <button
                            class="bg-blue-500 hover:bg-blue-600 active:bg-blue-700 text-white font-bold py-3 px-8 text-lg rounded-xl shadow-lg flex items-center gap-3 transition-all duration-200 transform hover:-translate-y-1 hover:scale-105">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" stroke-width="2.2"
                                viewBox="0 0 24 24">
                                <circle cx="8" cy="21" r="1"></circle>
                                <circle cx="19" cy="21" r="1"></circle>
                                <path
                                    d="M2.05 2.05 6 6h15l-1.68 8.39A2 2 0 0 1 17.36 16H8.64a2 2 0 0 1-1.96-1.61L4 8m0 0L2 2m2 6h16">
                                </path>
                            </svg>
                            加入購物車
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




<script>
    window.LaravelSessionMessages = {
        @if (session('success'))
            success: '{{ session('success') }}',
        @endif
        @if (session('error'))
            error: '{{ session('error') }}',
        @endif
        @if (session('warning'))
            warning: '{{ session('warning') }}',
        @endif
        @if (session('info'))
            info: '{{ session('info') }}',
        @endif
        @if ($errors->any())
            error: '{{ $errors->first() }}',
        @endif
    };



    document.addEventListener('DOMContentLoaded', function() {
        const stock = parseInt("{{ $product->stock }}");
        const quantityInput = document.getElementById('quantity');

        quantityInput.addEventListener('input', function() {
            const buy = parseInt(quantityInput.value);

            if (buy > stock) {
                alert('庫存不足！');
                quantityInput.value = stock; // 自動修正為最大可買數
            } else if (buy < 1) {
                quantityInput.value = 1;
            }
        });
    });
</script>
