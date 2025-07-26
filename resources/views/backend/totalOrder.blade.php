{{-- @php
    dd($pendingOrders);
@endphp --}}
@extends('adminlte::page')

@section('title', '查看訂單')

@section('content_header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">查看訂單</h1>
                    <span class="text-primary">你的權限為 {{ Auth::user()->role }}</span>
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
    <div class="container">
        <ul class="nav nav-tabs mb-3" id="orderTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending"
                    type="button" role="tab" aria-controls="pending" aria-selected="true">處理中</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed" type="button"
                    role="tab" aria-controls="completed" aria-selected="false">歷史訂單</button>
            </li>
        </ul>

        <div class="tab-content" id="orderTabsContent">
            <!-- 處理中 -->
            <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                @forelse ($pendingOrders as $order)
                    <div class="card mb-3">
                        <div class="card-body">
                            <div>🆔 訂單編號：<strong>{{ $order->id }}</strong></div>
                            <div>👤 使用者：{{ $order->user->name ?? '未知使用者' }}</div>
                            <div>💰 總金額：{{ number_format($order->total_price) }} 元</div>
                            <div>📅 建立時間：{{ $order->created_at->format('Y-m-d H:i') }}</div>
                            <div>📦 狀態：
                                <span class="badge bg-warning text-dark">{{ $order->status }}</span>
                            </div>

                            <form action="{{ route('admin.update-total-order', $order->id) }}" method="POST"
                                class="mt-2">
                                @csrf
                                @method('PATCH')
                                {{-- 假設你之後會設定 route，例如 route('orders.update', $order->id) --}}
                                {{-- <form action="{{ route('orders.update', $order->id) }}" method="POST"> --}}
                                <select name="status" id="status" class="form-select mt-2">
                                    <option value="0">選擇要更換的狀態</option>
                                    <option value="pending">待處理</option>
                                    <option value="processing">處理中</option>
                                    <option value="completed">已完成</option>
                                    <option value="cancelled">已取消</option>
                                    <option value="shipped">已送達</option>
                                </select>
                                <button type="submit" class="btn btn-primary btn-sm mt-2">更新狀態</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">目前沒有處理中的訂單。</p>
                @endforelse

                <div class="d-flex justify-content-center mt-3">
                    {{ $pendingOrders->withQueryString()->links() }}
                </div>
            </div>

            <!-- 歷史訂單 -->
            <div class="tab-pane fade" id="completed" role="tabpanel" aria-labelledby="completed-tab">
                @forelse ($completedOrders as $order)
                    <div class="card mb-3">
                        <div class="card-body">
                            <div>🆔 訂單編號：<strong>{{ $order->id }}</strong></div>
                            <div>👤 使用者：{{ $order->user->name ?? '未知使用者' }}</div>
                            <div>💰 總金額：{{ number_format($order->total_price) }} 元</div>
                            <div>📅 建立時間：{{ $order->created_at->format('Y-m-d H:i') }}</div>
                            <div>✅ 狀態：<span class="badge bg-success">{{ $order->status }}</span></div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">目前沒有歷史訂單。</p>
                @endforelse

                <div class="d-flex justify-content-center mt-3">
                    {{ $completedOrders->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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
@endpush
