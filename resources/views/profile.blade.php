@php
    $user = Auth::user();
@endphp

<div class="container mx-auto py-8">
    <div class="flex flex-col md:flex-row gap-8 justify-center">
        <!-- 🔥 修改：調整卡片寬度 - 移除 flex-1，加入最大寬度限制 -->
        <div class="bg-white rounded-2xl shadow-md p-6 w-full max-w-md md:max-w-lg">
            <h1 class="text-4xl font-bold mb-8">
                <span class="text-blue-500">{{ $user->name }}</span> 個人資料
            </h1>
            <!-- 🔥 改進：加入間距和標籤樣式 -->
            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-gray-600 mb-2 font-medium">姓名</label>
                    <input type="text" readonly
                        class="w-full border-gray-300 rounded-md p-2 bg-gray-50 focus:outline-none cursor-not-allowed"
                        value="{{ $user->name }}">
                </div>
                <div>
                    <label for="email" class="block text-gray-600 mb-2 font-medium">Email</label>
                    <input type="email" readonly
                        class="w-full border-gray-300 rounded-md p-2 bg-gray-50 focus:outline-none cursor-not-allowed"
                        value="{{ $user->email }}">
                </div>
                <div>
                    <label for="phone" class="block text-gray-600 mb-2 font-medium">手機</label>
                    <input type="tel" readonly
                        class="w-full border-gray-300 rounded-md p-2 bg-gray-50 focus:outline-none cursor-not-allowed"
                        value="{{ $user->phone ?? '未設定' }}">
                </div>
                <div>
                    <label for="gender" class="block text-gray-600 mb-2 font-medium">性別</label>
                    <input type="text" id="gender" name="gender"
                        class="w-full border-gray-300 rounded-md p-2 bg-gray-50 focus:outline-none cursor-not-allowed"
                        value="{{ $user->gender == 'male' ? '男' : ($user->gender == 'female' ? '女' : '未設定') }}"
                        readonly>
                </div>
            </div>

            <!-- 🔥 新增：操作按鈕區域 -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <!-- 主要操作按鈕 -->
                    <button type="button"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg transition duration-200 flex items-center justify-center gap-2"
                        data-modal-target="editModal" data-modal-toggle="editModal">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                        編輯資料
                    </button>

                    <!-- 次要操作按鈕 -->
                    <button type="button"
                        class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg transition duration-200 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                        修改密碼
                    </button>
                </div>


            </div>
        </div>
    </div>
    {{-- edit modal --}}
    <div id="editModal" tabindex="-1" aria-hidden="true"
    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full bg-black/40">
    <div class="relative w-full max-w-md max-h-full mx-auto flex items-center justify-center min-h-screen">
        <div class="relative bg-white rounded-2xl shadow dark:bg-gray-700 w-full p-8">
            <button type="button" class="absolute top-3 right-3 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                data-modal-hide="editModal">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                <span class="sr-only">關閉</span>
            </button>
            <form action="{{ route('profile.update', ['id' => $user->id]) }}" method="POST" class="space-y-4">
                @csrf
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">編輯個人資料</h3>
                <div>
                    <label for="edit-name" class="block mb-2 text-sm font-medium text-gray-900">姓名</label>
                    <input type="text" name="name" id="edit-name" value="{{ $user->name }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                </div>
                <div>
                    <label for="edit-email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                    <input type="email" name="email" id="edit-email" value="{{ $user->email }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                </div>
                <div>
                    <label for="edit-phone" class="block mb-2 text-sm font-medium text-gray-900">手機</label>
                    <input type="text" name="phone" id="edit-phone" value="{{ $user->phone }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                </div>
                <div>
                    <label for="edit-gender" class="block mb-2 text-sm font-medium text-gray-900">性別</label>
                    <select name="gender" id="edit-gender"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                        <option value="" {{ $user->gender == '' ? 'selected' : '' }}>未設定</option>
                        <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>男</option>
                        <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>女</option>
                    </select>
                </div>
                <div class="flex gap-2 justify-end mt-8">
                    <button type="button" data-modal-hide="editModal"
                        class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-lg">取消</button>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">儲存</button>
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
</script>
