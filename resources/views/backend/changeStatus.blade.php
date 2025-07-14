@extends('adminlte::page')

@section('title', '更換權限')
@section('content_header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">更換權限</h1>
                    <span class="text-primary"> 你的權限為 {{ Auth::user()->role }}</span>
                    <a href=""></a>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <ol class="breadcrumb">
                        {{ Breadcrumbs::render() }}
                    </ol>
                </div>
            </div>
        </div>
    </div>
@stop
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">更換權限</h2>
                {{-- 🔥 新增：搜索功能 --}}
                {{-- <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 250px;">
                        <input type="text" id="userSearch" class="form-control float-right" placeholder="搜索用戶名稱或Email">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div> --}}
            </div>

            <div class="card-body">
                @if ($users->count() > 0)
                    <div class="accordion" id="usersAccordion">
                        @foreach ($users as $item)
                            <div class="card mb-2 user-card" data-user-name="{{ strtolower($item->name) }}"
                                data-user-email="{{ strtolower($item->email) }}">
                                {{-- 用戶資訊顯示列 --}}
                                <div class="card-header p-3" id="heading{{ $item->id }}">
                                    <div class="row align-items-center">
                                        {{-- 🔥 修改：調整欄位寬度和排列 --}}
                                        <div class="col-md-3 col-sm-6">
                                            <strong>{{ $item->name }}</strong>
                                        </div>
                                        <div class="col-md-2 col-sm-6">
                                            @switch($item->role)
                                                @case('admin')
                                                    <span class="badge badge-danger">
                                                        <i class="fas fa-crown"></i> 管理員
                                                    </span>
                                                @break

                                                @case('boss')
                                                    <span class="badge badge-warning">
                                                        <i class="fas fa-briefcase"></i> 老闆
                                                    </span>
                                                @break

                                                @case('engineer')
                                                    <span class="badge badge-info">
                                                        <i class="fas fa-tools"></i> 工程師
                                                    </span>
                                                @break

                                                @case('member')
                                                    <span class="badge badge-success">
                                                        <i class="fas fa-user"></i> 會員
                                                    </span>
                                                @break

                                                @default
                                                    <span class="badge badge-secondary">
                                                        <i class="fas fa-user-secret"></i> 訪客
                                                    </span>
                                            @endswitch
                                        </div>
                                        <div class="col-md-3 col-sm-6">
                                            <small class="text-muted">Email:</small><br>
                                            {{ $item->email }}
                                        </div>
                                        <div class="col-md-2 col-sm-6">
                                            <small class="text-muted">手機:</small><br>
                                            {{ $item->phone ?? '未設定' }}
                                        </div>
                                        <div class="col-md-2 col-sm-12 text-right">
                                            {{-- 🔥 修改：增加確認功能和禁用自己編輯 --}}
                                            @if (Auth::user()->id !== $item->id)
                                                <button class="btn btn-sm btn-primary" type="button" data-toggle="collapse"
                                                    data-target="#collapse{{ $item->id }}" aria-expanded="false"
                                                    aria-controls="collapse{{ $item->id }}">
                                                    <i class="fas fa-edit"></i> 編輯
                                                </button>
                                            @else
                                                <span class="badge badge-info">
                                                    <i class="fas fa-info-circle"></i> 自己
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- 編輯表單（手風琴內容） --}}
                                @if (Auth::user()->id !== $item->id)
                                    <div id="collapse{{ $item->id }}" class="collapse"
                                        aria-labelledby="heading{{ $item->id }}" data-parent="#usersAccordion">
                                        <div class="card-body bg-light">
                                            <form action="{{ route('admin.changeStatus.update', $item->id) }}"
                                                method="POST" class="permission-form">
                                                @csrf
                                                @method('PUT')

                                                <div class="row">
                                                    {{-- 基本資料區塊 --}}
                                                    <div class="col-md-6">
                                                        <h5 class="text-primary">
                                                            <i class="fas fa-user-circle"></i> 基本資料
                                                        </h5>
                                                        <div class="form-group">
                                                            <label for="name{{ $item->id }}">用戶名稱</label>
                                                            <input type="text" class="form-control-plaintext"
                                                                id="name{{ $item->id }}" value="{{ $item->name }}"
                                                                readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="email{{ $item->id }}">Email</label>
                                                            <input type="email" class="form-control-plaintext"
                                                                id="email{{ $item->id }}" value="{{ $item->email }}"
                                                                readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="phone{{ $item->id }}">手機</label>
                                                            <input type="text" class="form-control-plaintext"
                                                                id="phone{{ $item->id }}"
                                                                value="{{ $item->phone ?? '未設定' }}" readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="gender{{ $item->id }}">性別</label>
                                                            <input type="text" class="form-control-plaintext"
                                                                id="gender{{ $item->id }}"
                                                                value="{{ $item->gender ?? '未設定' }}" readonly>
                                                        </div>
                                                    </div>

                                                    {{-- 權限設定區塊 --}}
                                                    <div class="col-md-6">
                                                        <h5 class="text-warning">
                                                            <i class="fas fa-key"></i> 權限設定
                                                        </h5>
                                                        <div class="form-group">
                                                            <label for="role{{ $item->id }}">
                                                                角色 <span class="text-danger">*</span>
                                                            </label>
                                                            <select class="form-control" id="role{{ $item->id }}"
                                                                name="role" required>
                                                                <option value="admin"
                                                                    {{ $item->role == 'admin' ? 'selected' : '' }}>
                                                                    👑 管理員
                                                                </option>
                                                                <option value="boss"
                                                                    {{ $item->role == 'boss' ? 'selected' : '' }}>
                                                                    💼 老闆
                                                                </option>
                                                                <option value="engineer"
                                                                    {{ $item->role == 'engineer' ? 'selected' : '' }}>
                                                                    🔧 工程師
                                                                </option>
                                                                <option value="member"
                                                                    {{ $item->role == 'member' ? 'selected' : '' }}>
                                                                    👤 會員
                                                                </option>
                                                                <option value="guest"
                                                                    {{ $item->role == 'guest' ? 'selected' : '' }}>
                                                                    👻 訪客
                                                                </option>
                                                            </select>
                                                            <small class="text-info">選擇新的角色權限</small>
                                                        </div>

                                                        {{-- 🔥 新增：權限說明 --}}
                                                        <div class="form-group">
                                                            <label>權限說明</label>
                                                            <div class="card">
                                                                <div class="card-body p-2">
                                                                    <small class="text-muted">
                                                                        <strong>管理員：</strong>所有功能權限<br>
                                                                        <strong>老闆：</strong>查看所有資料<br>
                                                                        <strong>工程師：</strong>技術相關功能<br>
                                                                        <strong>會員：</strong>基本功能權限<br>
                                                                        <strong>訪客：</strong>僅限瀏覽
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- 時間資訊 --}}
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h5 class="text-info">
                                                            <i class="fas fa-clock"></i> 時間資訊
                                                        </h5>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="created_at{{ $item->id }}">註冊時間</label>
                                                            <input type="text" class="form-control-plaintext"
                                                                id="created_at{{ $item->id }}"
                                                                value="{{ $item->created_at->format('Y-m-d H:i:s') }}"
                                                                readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="updated_at{{ $item->id }}">最後更新</label>
                                                            <input type="text" class="form-control-plaintext"
                                                                id="updated_at{{ $item->id }}"
                                                                value="{{ $item->updated_at->format('Y-m-d H:i:s') }}"
                                                                readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- 操作按鈕 --}}
                                                <div class="form-group text-right">
                                                    <button type="button" class="btn btn-secondary mr-2"
                                                        data-toggle="collapse"
                                                        data-target="#collapse{{ $item->id }}">
                                                        <i class="fas fa-times"></i> 取消
                                                    </button>
                                                    <button type="submit" class="btn btn-success confirm-change">
                                                        <i class="fas fa-save"></i> 儲存角色變更
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle fa-2x mb-2"></i>
                        <h5>目前沒有用戶資料</h5>
                        <p class="mb-0">請等待用戶註冊或聯繫系統管理員</p>
                    </div>
                @endif
            </div>

            <div class="card-footer d-flex justify-content-between">
                <span>共 {{ $users->count() }} 位用戶</span>
                {{-- 🔥 新增：統計資訊 --}}
                <small class="text-muted">
                    管理員: {{ $users->where('role', 'admin')->count() }} |
                    老闆: {{ $users->where('role', 'boss')->count() }} |
                    工程師: {{ $users->where('role', 'engineer')->count() }} |
                    會員: {{ $users->where('role', 'member')->count() }} |
                    訪客: {{ $users->where('role', 'guest')->count() }}
                </small>
            </div>
        </div>
    </div>
@stop

@section('js')
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
@stop
