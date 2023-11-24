@extends('layouts.master')
@section('content')
<!-- .page-title-bar -->
<header class="page-title-bar">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">
                <a href="{{ route('assets.index') }}"><i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Quản Lý
                    Tài sản</a>
            </li>
        </ol>
    </nav>
    <h1 class="page-title"> Chỉnh Sửa thiết bị </h1>
</header>

<div class="page-section">
    <form method="post" action="{{ route('assets.update', $item->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-body">
                <legend>Thông tin cơ bản</legend>
                <div class="form-group">
                    <div class="form-group">
                        <label for="tf1">Tên tài sản <abbr name="Trường bắt buộc">*</abbr></label> <input name="name"
                            type="text" value="{{ old('name',$item->name) }}" class="form-control" id=""
                            placeholder="Nhập tên tài sản">
                        <small id="" class="form-text text-muted"></small>
                        @error('name')
                        <p style="color:red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="tf1">Nước sản xuât <abbr name="Trường bắt buộc">*</abbr></label> <input
                            name="country" type="text" value="{{ old('country',$item->country) }}" class="form-control"
                            id="" placeholder="Nhập tên nước">
                        <small id="" class="form-text text-muted"></small>
                        @error('country')
                        <p style="color:red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="tf1">Năm sản xuât <abbr name="Trường bắt buộc">*</abbr></label> <input name="year"
                            type="number" value="{{ old('year',$item->year) }}" class="form-control" id=""
                            placeholder="Nhập năm sản xuất">
                        <small id="" class="form-text text-muted"></small>
                        @error('year')
                        <p style="color:red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="tf1">Số lượng<abbr name="Trường bắt buộc">*</abbr></label> <input name="quantity"
                            type="number" value="{{ old('quantity',$item->quantity) }}" class="form-control" id=""
                            placeholder="Nhập số lượng">
                        <small id="" class="form-text text-muted"></small>
                        @error('quantity')
                        <p style="color:red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="tf1">Đơn Vị<abbr name="Trường bắt buộc">*</abbr></label> <input name="unit"
                            type="text" value="{{ old('unit',$item->unit) }}" class="form-control" id=""
                            placeholder="Nhập đơn vị">
                        <small id="" class="form-text text-muted"></small>
                        @error('unit')
                        <p style="color:red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="tf1">Giá Tiền<abbr name="Trường bắt buộc">*</abbr></label> <input name="price"
                            type="number" value="{{ old('price',$item->price) }}" class="form-control" id=""
                            placeholder="Nhập giá tiền">
                        <small id="" class="form-text text-muted"></small>
                        @error('price')
                        <p style="color:red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="tf1">Ghi chú<abbr name="Trường bắt buộc">*</abbr></label> <textarea name="note"
                            type="text" value="{{ old('note',$item->note) }}" class="form-control" id=""
                            placeholder="Nhập ghi chú">{{ old('note',$item->note) }}</textarea>
                        <small id="" class="form-text text-muted"></small>
                        @error('note')
                        <p style="color:red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1" class="form-label">Ảnh</label>
                        <input type="file" class="form-control" name="image" id="imageInput" value="{{ $item->image }}">
                        <img width="50px" height="50px" id="imagePreview" src="{{ $item->image }}" alt="">
                    </div>
                    <div class="form-group">
                        <label for="tf1">Loại tài sản<abbr name="Trường bắt buộc"></abbr></label>
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
                        <a class="btn btn-secondary float-right" href="{{ route('assets.index') }}">Hủy</a>
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