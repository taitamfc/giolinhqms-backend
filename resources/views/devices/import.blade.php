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
    <form method="post" action="{{ route('devices.import') }}" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <label for="tf1">Chọn file<abbr name="Trường bắt buộc">*</abbr></label>
                        <input name="importData" type="file" class="form-control" id=""
                            placeholder="Nhập tên thiết bị">
                        <small id="" class="form-text text-muted"></small>
                        @error('importData')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
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