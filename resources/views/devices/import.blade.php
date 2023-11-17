@extends('layouts.master')
@section('content')
<header class="page-title-bar">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">
                <a href="{{ route('devices.index') }}"><i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Quản Lý
                    Thiết Bị</a>
            </li>
        </ol>
    </nav>
    <h1 class="page-title">Thêm thiết bị</h1>
</header>

<div class="page-section">
    @if (session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif
    @if ($errors->any())
    @foreach($errors->all() as $error)
    @if ($error !== 'Vui lòng chọn file có đuôi .xlsx hoặc xls!')
    <div class="alert alert-danger" role="alert">
        {{ $error }} <br>
    </div>
    @endif
    @endforeach
    @endif
    <form method="post" action="{{ route('devices.import') }}" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="tf1">Chọn file<abbr name="Trường bắt buộc">*</abbr></label>
                        <input name="importData" type="file" class="form-control" id="" placeholder="Nhập tên thiết bị"
                            accept=".xls, .xlsx" />
                        <small id="" class="form-text text-muted"></small>
                        @error('importData')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-4 border-left">
                        <div class="form-check mt-4">
                            <label for="tf1" class='mr-4'>Chọn định dạng file : <abbr
                                    name="Trường bắt buộc">*</abbr></label>
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckCheckedDisabled"
                                checked disabled>
                            <label class="form-check-label" for="flexCheckCheckedDisabled">
                                Nhập file .xls(Excel)
                            </label>
                        </div>
                        <div class="form-check mt-4">
                            <label for="tf1" class='mr-4'>Tải dữ liệu mẫu : <abbr
                                    name="Trường bắt buộc">*</abbr></label>
                            <a href="{{ asset('storage/sample/device.xlsx') }}">Mẫu thiết bị.xlsx</a>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <a class="btn btn-secondary float-right" href="{{ route('devices.index') }}">Hủy</a>
                    <button class="btn btn-primary ml-auto" type="submit">Lưu</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection