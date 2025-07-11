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
            </div>
            <div class="card-body">
                @if ($users->count() > 0)
                    <div class="accordion" id="usersAccordion">
                        @foreach ($users as $item)
                            <div class="card mb-2">
                                {{-- 用戶資訊顯示列 --}}
                                <div class="card-header p-2" id="heading{{ $item->id }}">
                                    <div class="row align-items-center">
                                        <div class="col-3">
                                            <strong>{{ $item->name }}</strong>
                                        </div>
                                        <div class="col-2">
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
                                        <div class="col-4">{{ $item->email }}</div>
                                        <div class="col-3">
                                            {{-- 編輯按鈕（展開手風琴） --}}
                                            <button class="btn btn-sm btn-primary" type="button" data-toggle="collapse"
                                                data-target="#collapse{{ $item->id }}" aria-expanded="false"
                                                aria-controls="collapse{{ $item->id }}">
                                                <i class="fas fa-edit"></i> 編輯
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                {{-- 編輯表單（手風琴內容） --}}
                                <div id="collapse{{ $item->id }}" class="collapse"
                                    aria-labelledby="heading{{ $item->id }}" data-parent="#usersAccordion">
                                    <div class="card-body">
                                        <form action="{{ route('admin.changeStatus.update', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <div class="row">
                                                {{-- 名字（只讀） --}}
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="name{{ $item->id }}">用戶名稱</label>
                                                        <input type="text" class="form-control"
                                                            id="name{{ $item->id }}" value="{{ $item->name }}"
                                                            readonly>
                                                        <small class="text-muted">此欄位不可修改</small>
                                                    </div>
                                                </div>

                                                {{-- Email（只讀） --}}
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="email{{ $item->id }}">Email</label>
                                                        <input type="email" class="form-control"
                                                            id="email{{ $item->id }}" value="{{ $item->email }}"
                                                            readonly>
                                                        <small class="text-muted">此欄位不可修改</small>
                                                    </div>
                                                </div>

                                                {{-- 角色（可編輯） --}}
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="role{{ $item->id }}">角色 <span
                                                                class="text-danger">*</span></label>
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
                                                        <small class="text-info">只有角色可以修改</small>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- 註冊時間（只讀） --}}
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="created_at{{ $item->id }}">註冊時間</label>
                                                        <input type="text" class="form-control"
                                                            id="created_at{{ $item->id }}"
                                                            value="{{ $item->created_at->format('Y-m-d H:i:s') }}"
                                                            readonly>
                                                        <small class="text-muted">此欄位不可修改</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="updated_at{{ $item->id }}">最後更新</label>
                                                        <input type="text" class="form-control"
                                                            id="updated_at{{ $item->id }}"
                                                            value="{{ $item->updated_at->format('Y-m-d H:i:s') }}"
                                                            readonly>
                                                        <small class="text-muted">此欄位不可修改</small>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <button type="submit" class="btn btn-success">
                                                    <i class="fas fa-save"></i> 儲存角色變更
                                                </button>
                                                <button type="button" class="btn btn-secondary" data-toggle="collapse"
                                                    data-target="#collapse{{ $item->id }}">
                                                    <i class="fas fa-times"></i> 取消
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        目前沒有用戶資料
                    </div>
                @endif
            </div>
            <div class="card-footer">
                共 {{ $users->count() }} 位用戶
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