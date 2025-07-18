<div class="container mx-auto mt-10">
    <div
        class="max-w-sm mx-auto p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 text-white">
        <form action="{{ route('login.submit') }}" method="POST">
            <h1 class="text-center text-2xl">登入</h1>
            @csrf
            <div class="mb-4">
                <label for="email" class="block mb-1">Email</label>
                <input type="email" name="email" id="email" required class="w-full p-2 text-black rounded">
            </div>
            <div class="mb-4">
                <label for="password" class="block mb-1">Password</label>
                <input type="password" name="password" id="password" required class="w-full p-2 text-black rounded">
                <small><a href="{{ route('forgot-password') }}" class="text-blue-500">忘記密碼</a></small>
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded text-white w-full">
                Login
            </button>
        </form>
        <div class="mt-4">
            <a href="{{ route('register') }}"
                class="block text-center bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded text-white">
                註冊
            </a>
        </div>
    </div>
</div>
