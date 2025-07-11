@extends('adminlte::page')

@section('title', '後台首頁')
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
@stop
