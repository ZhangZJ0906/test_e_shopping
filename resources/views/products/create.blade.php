@extends('adminlte::page')

@section('title', '新增商品')

@section('content_header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">新增商品</h1>
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
    <div class="card">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label>商品名稱</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
                <div class="form-group">
                    <label>價格</label>
                    <input type="number" class="form-control" name="price" step="0.01" required>
                </div>
                <div class="form-group">
                    <label>庫存</label>
                    <input type="number" class="form-control" name="stock" required>
                </div>
                <div class="form-group">
                    <label>詳述 </label>
                    <input type="text" class="form-control" name="description" required>
                </div>
                <div class="form-group">
                    <label>圖片</label>
                    <input type="file" class="form-control" name="image" required>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">新增</button>
                <a href="{{ route('admin.products') }}" class="btn btn-secondary">取消</a>
            </div>
        </form>
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

