<!DOCTYPE html>
<html lng="zh-TW">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ $metaDescription }}">
    <meta name="keywords" content="{{ $metaKeywords }}">
    <link rel="canonical" href="{{ $canonicalUrl }}">
    <link rel="icon" href="/LOGO.ico"></link>
    <title>{{ $name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen flex flex-col bg-white  text-gray-800">
    {{-- 導覽列 (如果有的話) --}}
    <x-navbar />
    {{-- 主要內容區塊 --}}
    <div class="main">
        @isset($view)
            @include($view)
        @endisset
    </div>
    <x-footer />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../node_modules/flowbite/dist/flowbite.min.js"></script>
    <!-- Laravel Session 訊息 -->
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

</body>

</html>
