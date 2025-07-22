@php use Illuminate\Support\Str; @endphp
<div class="container mx-auto px-4">

    @if ($isLoggedIn)
        {{-- 已登入的歡迎訊息 --}}
        <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-4">
            <p>歡迎回來，{{ $currentUser->name }} ！</p>
        </div>
    @else
        {{-- 未登入的歡迎訊息 --}}
        <div class="bg-gray-100 border-l-4 border-gray-500 text-gray-700 p-4 mb-4">
            <p>歡迎來到 <span
                    class="font-bold text-xl text-blue-600 bg-gradient-to-r from-blue-500 to-purple-600 bg-clip-text text-transparent">{{ $siteName }}</span>
                ！請先 <a href="{{ route('login') }}" class="text-blue-600 hover:underline">登入</a> 體驗完整功能</p>
        </div>
    @endif
    <x-carousel />

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mt-14">
        @foreach ($products as $item)
            <div class="bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <img class="rounded-t-lg" src="{{  $item->image ? asset('storage/' . $item->image) : asset('images/default.png')  }}"
                    alt="{{ $item->description }}">
                <div class="p-5">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $item->name }}</h5>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ Str::limit($item->description, 10)}}</p>
                    <a href="{{route('frontendProducts.show', ['id' => $item->id])}}"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800">詳細內容</a>
                </div>
            </div>
        @endforeach
    </div>

</div>
