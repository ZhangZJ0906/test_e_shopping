<div class="container mx-auto mt-10">
    <div
        class="max-w-sm mx-auto p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 text-white ">
        <form action="{{ route('register.submit') }}" method="POST">
            <h1 class="text-center text-2xl">註冊</h1>
            @csrf

            <div class="mb-4">
                <label for="email" class="block mb-1">Email</label>
                <input type="email" name="email" id="email" required class="w-full p-2 text-black rounded" placeholder="請輸入Email">
            </div>
            <div class="mb-4">
                <label for="name" class="block mb-1">Name</label>
                <input type="name" name="name" id="name" required class="w-full p-2 text-black rounded" placeholder="請輸入姓名">
            </div>
            <div class="mb-4">
                <label for="gender" class="block mb-1">性別</label>
                <select name="gender" id="gender" required class="w-full p-2 text-black rounded">
                    <option value="" disabled selected>請選擇性別</option>
                    <option value="male">男</option>
                    <option value="female">女</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="phone" class="block mb-1">手機</label>
                <input type='tel' name="phone" id="phone" required class="w-full p-2 text-black rounded" placeholder="請輸入手機號碼">
            </div>
            <div class="mb-4">
                <label for="password" class="block mb-1">Password</label>
                <input type="password" name="password" id="password" required class="w-full p-2 text-black rounded" placeholder="請輸入密碼">
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded text-white w-full">
                註冊
            </button>
        </form>

        <div class="mt-4">
            <a href="{{ route('login') }}"
                class="block text-center bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded text-white">
                返回登入
            </a>
        </div>
    </div>
</div>
