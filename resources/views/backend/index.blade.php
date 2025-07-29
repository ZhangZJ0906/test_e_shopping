@extends('adminlte::page')
@section('plugins.Chartjs', true)
@section('title', '後台首頁')
@vite('resources/js/backendChart.js')

@section('content_header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">歡迎回來，<span class="text-primary">{{ Auth::user()->name }}</span> 這裡是後台</h1>
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
    {{-- 您的後台內容 --}}

    <div class="row">
        <!-- 狀態圖表 -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">訂單狀態分佈</div>
                <div class="card-body">
                    <div style="position:relative; height:300px;">
                        <canvas id="statusChart" data-labels='@json($statusLabels)'
                            data-data='@json($statusData)'></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- 每日訂單金額 -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">每日訂單金額趨勢</div>
                <div class="card-body">
                    <div style="position:relative; height:300px;">
                        <canvas id="dailyChart" data-labels='@json($dailyLabels)'
                            data-data='@json($dailyData)'></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
