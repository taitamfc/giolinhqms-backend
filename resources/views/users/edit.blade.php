@extends('layouts.master')
@section('content')
    <header class="page-title-bar">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <a href="{{ route('users.index') }}"><i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Quản Lý
                        Giáo Viên</a>
                </li>
            </ol>
        </nav>
        <h1 class="page-title">Sửa Thông Tin Giáo Viên</h1>
    </header>
    <div class="page-section">
        <form method="post" action="{{ route('users.update', $item->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-body">
                    <legend>Thông tin cơ bản</legend>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="tf1">Tên giáo viên<abbr name="Trường bắt buộc">*</abbr></label>
                            <input name="name" value="{{ old('name', $item->name) }}" type="text" class="form-control"
                                id="" placeholder="Nhập tên giáo viên">
                            <small id="" class="form-text text-muted"></small>
                            @if ($errors->any())
                                <p style="color:red">{{ $errors->first('name') }}</p>
                            @endif
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="tf1">Email<abbr name="Trường bắt buộc">*</abbr></label>
                            <input name="email" type="text" value="{{ old('email', $item->email) }}"
                                class="form-control" id="" placeholder="Nhập E-mail">
                            <small id="" class="form-text text-muted"></small>
                            @if ($errors->any())
                                <p style="color:red">{{ $errors->first('email') }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="tf1">Mật khẩu<abbr name="Trường bắt buộc"></abbr></label>

                            <input name="password" type="password" class="form-control" id=""
                                placeholder="Nhập mật khẩu">
                            <small id="" class="form-text text-muted"></small>
                            @if ($errors->any())
                                <p style="color:red">{{ $errors->first('password') }}</p>
                            @endif
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="tf1">Địa chỉ<abbr name="Trường bắt buộc">*</abbr></label>
                            <input name="address" type="text" value="{{ old('address', $item->address) }}"
                                class="form-control" id="" placeholder="Nhập địa chỉ">
                            <small id="" class="form-text text-muted"></small>
                            @if ($errors->any())
                                <p style="color:red">{{ $errors->first('address') }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="tf1">Số điện thoại<abbr name="Trường bắt buộc">*</abbr></label>
                            <input name="phone" type="text" value="{{ old('phone', $item->phone) }}"
                                class="form-control" id="" placeholder="Nhập số điện thoại">
                            <small id="" class="form-text text-muted"></small>
                            @if ($errors->any())
                                <p style="color:red">{{ $errors->first('phone') }}</p>
                            @endif
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="tf1">Ngày sinh<abbr name="Trường bắt buộc">*</abbr></label>
                            <input name="birthday" type="date" value="{{ old('birthday', $item->birthday) }}"
                                class="form-control" id="" placeholder="">
                            <small id="" class="form-text text-muted"></small>
                            @if ($errors->any())
                                <p style="color:red">{{ $errors->first('birthday') }}</p>
                            @endif
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="tf1">Giới tính<abbr name="Trường bắt buộc">*</abbr></label>
                            <select value="{{ $item->gender }}" name="gender" id="" class="form-control">
                                <option value="Nam" {{ $item->gender == 'Nam' ? 'selected' : '' }}>Nam
                                </option>
                                <option value="Nữ" {{ $item->gender == 'Nữ' ? 'selected' : '' }}>Nữ
                                </option>
                                <option value="Khác" {{ $item->gender == 'Khác' ? 'selected' : '' }}>Khác
                                </option>
                            </select>
                            <small id="" class="form-text text-muted"></small>
                            @if ($errors->any())
                                <p style="color:red">{{ $errors->first('gender') }}</p>
                            @endif
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="tf1">Chức vụ<abbr name="Trường bắt buộc">*</abbr></label>
                            <select name="group_id" id="" class="form-control">
                                <option value="">--Vui lòng chọn--</option>
                                @foreach ($groups as $group)
                                    <option value="{{ $group->id }}"
                                        {{ $group->id == $item->group_id ? 'selected' : '' }}>
                                        {{ $group->name }}</option>
                                @endforeach
                            </select>
                            <small id="" class="form-text text-muted"></small>
                            @if ($errors->any())
                                <p style="color:red">{{ $errors->first('group_id') }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="tf1">Ảnh<abbr name="Trường bắt buộc"></abbr></label>
                            <input type="file" class="form-control" name="image">
                            <img src="{{ asset($item->image) ?? asset('public/users' . old('image', $item->image)) }}"
                                width="90px" height="90px" id="blah1" alt="">
                            <small id="" class="form-text text-muted"></small>
                            @if ($errors->any())
                                <p style="color:red">{{ $errors->first('image') }}</p>
                            @endif
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="tf1">Tổ<abbr name="Trường bắt buộc">*</abbr></label>
                            <select name="nest_id" id="" class="form-control">
                                <option value="">--Vui lòng chọn--</option>
                                @foreach ($nests as $nest)
                                    <option value="{{ $nest->id }}"
                                        {{ $nest->id == $item->nest_id ? 'selected' : '' }}>
                                        {{ $nest->name }}</option>
                                @endforeach
                            </select>
                            <small id="" class="form-text text-muted"></small>
                            @if ($errors->any())
                                <p style="color:red">{{ $errors->first('nest_id') }}</p>
                            @endif
                        </div>

                    </div>
                    <div class="form-actions">
                        <a class="btn btn-secondary float-right" href="{{ route('users.index') }}">Hủy</a>
                        <button class="btn btn-primary ml-auto" type="submit">Lưu thay đổi</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
