@extends('adminlte::page')

@section('title', '商品管理')

@section('content_header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">商品管理</h1>
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
                <h3 class="card-title">商品列表</h3>
                <div class="card-tools">
                    {{-- 新增商品按鈕 --}}
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> 新增商品
                    </a>
                </div>
            </div>

            <div class="card-body">
                @if ($products->count() > 0)
                    <div class="accordion" id="productsAccordion">
                        @foreach ($products as $item)
                            <div class="card mb-2">
                                {{-- 商品資訊顯示列 --}}
                                <div class="card-header p-2" id="heading{{ $item->id }}">
                                    <div class="row align-items-center">
                                        <div class="col-1">{{ $item->id }}</div>
                                        <div class="col-2">{{ $item->name }}</div>
                                        <div class="col-1">${{ number_format($item->price, 2) }}</div>
                                        <div class="col-1">
                                            @if ($item->stock > 0)
                                                <span class="badge badge-success">{{ $item->stock }}</span>
                                            @else
                                                <span class="badge badge-danger">缺貨</span>
                                            @endif
                                        </div>
                                        <div class="col-2">{{ Str::limit($item->description, 20) }}</div>
                                        <div class="col-1">
                                            @if ($item->image)
                                                <a href="{{ asset('storage/' . $item->image) }}" data-toggle="lightbox"
                                                    data-size="large">
                                                    <img src="{{ asset('storage/' . $item->image) }}" width="100"
                                                        height="30" class="img-thumbnail">
                                                </a>
                                            @else
                                                無圖片
                                            @endif
                                        </div>
                                        <div class="col-3">
                                            {{-- 編輯按鈕（展開手風琴） --}}
                                            <button class="btn btn-sm btn-primary" type="button" data-toggle="collapse"
                                                data-target="#collapse{{ $item->id }}" aria-expanded="false"
                                                aria-controls="collapse{{ $item->id }}">
                                                <i class="fas fa-edit"></i> 編輯
                                            </button>
                                            {{-- 刪除按鈕 --}}
                                            <form action="{{ route('admin.products.destroy', $item->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('確定刪除？')">
                                                    <i class="fas fa-trash"></i> 刪除
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                {{-- 編輯表單（手風琴內容） --}}
                                <div id="collapse{{ $item->id }}" class="collapse"
                                    aria-labelledby="heading{{ $item->id }}" data-parent="#productsAccordion">
                                    <div class="card-body">
                                        <form action="{{ route('admin.products.update', $item->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="name{{ $item->id }}">商品名稱</label>
                                                        <input type="text" class="form-control"
                                                            id="name{{ $item->id }}" name="name"
                                                            value="{{ $item->name }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="price{{ $item->id }}">價格</label>
                                                        <input type="number" class="form-control"
                                                            id="price{{ $item->id }}" name="price"
                                                            value="{{ $item->price }}" step="0.01" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="stock{{ $item->id }}">庫存</label>
                                                        <input type="number" class="form-control"
                                                            id="stock{{ $item->id }}" name="stock"
                                                            value="{{ $item->stock }}" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="description{{ $item->id }}">商品描述</label>
                                                <textarea class="form-control" id="description{{ $item->id }}" name="description" rows="3">{{ $item->description }}</textarea>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="image{{ $item->id }}">商品圖片</label>
                                                        <input type="file" class="form-control-file"
                                                            id="image{{ $item->id }}" name="image"
                                                            accept="image/*">
                                                        @if ($item->image)
                                                            <small class="text-muted">目前圖片：</small>
                                                            <a href="{{ asset('storage/' . $item->image) }}"
                                                                data-toggle="lightbox" data-size="large">
                                                                <img src="{{ asset('storage/' . $item->image) }}"
                                                                    width="100" height="100"
                                                                    class="img-thumbnail mt-2">
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <button type="submit" class="btn btn-success">
                                                    <i class="fas fa-save"></i> 儲存修改
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
                        目前沒有商品資料
                    </div>
                @endif
            </div>

            <div class="card-footer">
                共 {{ $products->count() }} 個商品
            </div>
        </div>

    </div>

@stop


@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bs5-lightbox@1.8.3/dist/index.bundle.min.js"></script> {{-- 預覽圖片--}}

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
