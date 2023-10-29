@extends('layouts.master')
@section('content')
    <!-- .page-title-bar -->
    <header class="page-title-bar">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <a href="{{ route('devices.index') }}"><i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Quản Lý Thiết
                        Bị</a>
                </li>
            </ol>
        </nav>
        <h1 class="page-title"> Chỉnh Sửa thiết bị </h1>
    </header>

    <div class="page-section">
        <form method="post" action="{{ route('devices.update', $item->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-body">
                    <legend>Thông tin cơ bản</legend>

                    <div class="form-group">
                        <label for="tf1">Tên thiết bị</label> <input type="text" name="name"
                            value="{{ old('name',$item->name) }}" class="form-control" placeholder="Nhập tên thiết bị">
                        <small class="form-text text-muted"></small>
                        @if ($errors->any())
                            <p style="color:red">{{ $errors->first('name') }}</p>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="tf1"> Số lượng </label> <input type="number" name="quantity"
                            value="{{ old('quantity',$item->quantity) }}" class="form-control" placeholder="Nhập địa chỉ">
                        <small class="form-text text-muted"></small>
                        @if ($errors->any())
                            <p style="color:red">{{ $errors->first('quantity') }}</p>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1" class="form-label">Ảnh</label>
                        <input type="file" class="form-control" name="image" id="imageInput"
                            value="{{ $item->image }}">
                        <img width="50px" height="50px" id="imagePreview" src="{{ $item->image }}" alt="">
                    </div>
                    <div class="form-group">
                        <label for="tf1">Loại thiết bị<abbr name="Trường bắt buộc"></abbr></label>
                        <select name="device_type_id" class="form-control">
                            <option value="">--Vui lòng chọn--</option>
                            @foreach ($devicetypes as $devicetype)
                                <option value="{{ $devicetype->id }}"
                                    {{ $devicetype->id == $item->device_type_id ? 'selected' : '' }}>
                                    {{ $devicetype->name }}
                                </option>
                            @endforeach
                        </select>
                        <small id="" class="form-text text-muted"></small>
                        @if ($errors->any())
                            <p style="color:red">{{ $errors->first('device_type_id') }}</p>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="tf1">Bộ môn<abbr name="Trường bắt buộc"></abbr></label>
                        <select name="department_id" class="form-control">
                            <option value="">--Vui lòng chọn--</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}"
                                    {{ $department->id == $item->department_id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                        <small id="" class="form-text text-muted"></small>
                        @if ($errors->any())
                            <p style="color:red">{{ $errors->first('department_id') }}</p>
                        @endif
                    </div>
                    <div class="form-actions">
                        <a class="btn btn-secondary float-right" href="{{ route('devices.index') }}">Hủy</a>
                        @if (Auth::check())
                            <button class="btn btn-primary ml-auto" type="submit">Cập nhật</button>
                        @endif
                    </div>
                </div>
            </div>
    </div>
    </form>
    </div>
@endsection
