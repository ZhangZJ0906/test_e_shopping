<div class="flex justify-center bg-gray-50 py-24">
    <div class="w-full max-w-md">
        <div class="relative bg-white rounded-lg border border-gray-200 shadow dark:bg-gray-800 dark:border-gray-700">
            <!-- Card header: icon & 標題 -->
            <div class="flex flex-col items-center pt-8">
                <!-- Flowbite Icon (書本) -->
                <div class="mb-2 text-2xl text-blue-600">
                    🔐
                </div>
                <h2 class="mb-2 text-2xl font-bold text-gray-900 dark:text-white text-center">忘記密碼</h2>
            </div>
            <!-- Card body -->
            <div class="p-8 pt-4">
                <div id="forgot-step1">
                    <div class="mb-4">
                        <label for="forgot_email"
                            class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">請輸入你的 Email</label>
                        <input type="email" id="forgot_email"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="name@example.com" autocomplete="email" required>
                        <div class="mt-2 text-sm text-red-600" id="email_error"></div>
                    </div>
                    <button id="check_email_btn"
                        class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-all">
                        確認
                    </button>
                </div>
                <div id="forgot-step2" style="display:none;">
                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">已驗證信箱：</label>
                        <div class="px-4 py-2 bg-gray-100 rounded" id="show_email"></div>
                    </div>
                    <div class="mb-4">
                        <label for="reset_password"
                            class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">新密碼</label>
                        <input type="password" id="reset_password"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            autocomplete="new-password" required>
                        <div class="mt-2 text-sm text-red-600" id="password_error"></div>
                    </div>
                    <div class="mb-4">
                        <label for="reset_password_confirm"
                            class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">再次輸入新密碼</label>
                        <input type="password" id="reset_password_confirm"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            autocomplete="new-password" required>
                    </div>
                    <button id="reset_password_btn"
                        class="w-full text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-all">
                        變更密碼
                    </button>
                </div>
                <div id="reset-success"
                    class="hidden mt-6 alert alert-success text-green-700 bg-green-100 border border-green-300 px-4 py-3 rounded">
                </div>
            </div>
        </div>
    </div>
</div>


@vite('resources/js/forgot-password.js')
<script>
    window.addEventListener('DOMContentLoaded', function() {
        window.ForgotPassword.bind();
    });

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
</script>
