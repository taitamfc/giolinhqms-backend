@extends('layouts.master')
@section('content')
    <header class="page-title-bar">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <a href="#"><i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Trang Chủ</a>
                </li>
            </ol>
        </nav>
        <div class="d-md-flex align-items-md-start">
            <h1 class="page-title mr-sm-auto">Phiếu Mượn #{{ $item->id }} </h1>
            <a href="{{ route('export_PDF', $item->id) }}" class="btn btn-primary ">
                <i class='fas fa-file-alt'></i>
                <span class="ml-1">Xuất File PDF</span>
            </a>
        </div>
    </header>
    <div class="page-section">
        <div class="card card-fluid">
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                <form action="{{ route('borrows.updateBorrow', ['id' => $item->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-lg-6">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td> Mã </td>
                                        <td>{{ $item->id }}</td>
                                    </tr>
                                    <tr>
                                        <td> Ngày tạo phiếu </td>
                                        <td>{{ date('d/m/Y H:i:s', strtotime($item->created_at)) }}</td>

                                    </tr>
                                    <tr>
                                        <td> Ngày mượn </td>
                                        <td> {{ date('d/m/Y', strtotime($item->borrow_date)) }} </td>
                                    </tr>
                                    <!-- Trạng thái -->
                                    <tr>
                                        @if (Auth::user()->hasPermission('Borrow_update_status'))
                                        <td> Tình trạng </td>
                                        <td>
                                            <select name="status" class="form-control">
                                                <option value="0" {{ $item->status == '0' ? 'selected' : '' }}>Chưa
                                                    trả
                                                </option>
                                                <option value="1" {{ $item->status == '1' ? 'selected' : '' }}>Đã
                                                    trả
                                                </option>
                                            </select>
                                        </td>
                                        @endif
                                    </tr>
                                    <!-- Trạng thái duyệt -->
                                    <tr>
                                        @if (Auth::user()->hasPermission('Borrow_update_approved'))
                                        <td> Trạng thái duyệt </td>
                                        <td>
                                            <select name="approved" class="form-control">
                                                <option value="0" {{ $item->approved == '0' ? 'selected' : '' }}>Chưa
                                                    xét duyệt</option>
                                                <option value="1" {{ $item->approved == '1' ? 'selected' : '' }}>Đã
                                                    xét
                                                    duyệt</option>
                                                <option value="2" {{ $item->approved == '2' ? 'selected' : '' }}>Từ
                                                    chối
                                                </option>
                                            </select>
                                        </td>
                                        @endif
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-6">
                            <table class="table table-bordered">
                                <thead class="thead-">
                                    <tr>
                                        <th colspan="2">Thông tin người mượn</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td> Tên </td>
                                        <td> {{ $user->name }}</td>
                                    </tr>
                                    <tr>
                                        <td> Email </td>
                                        <td> {{ $user->email }} </td>
                                    </tr>
                                    <tr>
                                        <td> Số điện thoại </td>
                                        <td> {{ $user->phone }} </td>
                                    </tr>
                                    <tr>
                                        <td> Địa chỉ </td>
                                        <td> {{ $user->address }} </td>
                                    </tr>
                                    <tr>
                                        <td> Ghi chú </td>
                                        <td> {{ $item->borrow_note }} </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Chi tiết thiết bị -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tên thiết bị</th>
                                            <th>Tên bài dạy</th>
                                            <th>Số lượng</th>
                                            <th>Buổi</th>
                                            <th>Tiết PCCT</th>
                                            <th>Lớp</th>
                                            <th>Tiết TKB</th>
                                            <th>Ngày trả</th>
                                            @if ($item->approved == 1)
                                                <th>Trạng thái</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($the_devices as $index => $the_device)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <a class="tile tile-img mr-1">
                                                        <img src="{{ asset($the_device->device->image) }}"
                                                            alt="Ảnh sản phẩm" style="max-width: 100px; max-height: 100px;">
                                                        <a href="{{ route('devices.edit', $the_device->device->id) }}">{{ $the_device->device->name }}
                                                            (SL: {{ $the_device->device->quantity }})
                                                        </a>
                                                </td>
                                                <td>{{ $the_device->lesson_name }}</td>
                                                <td>{{ $the_device->quantity }}</td>
                                                <td>{{ $the_device->session }}</td>
                                                <td>{{ $the_device->lecture_name }}</td>
                                                <td>{{ $the_device->room ? $the_device->room->name : '' }}</td>
                                                <td>{{ $the_device->lecture_number }}</td>
                                                <td>{{ $the_device->return_date ? date('d-m-Y', strtotime($the_device->return_date)) : '' }}
                                                </td>
                                                @if (Auth::user()->hasPermission('Borrow_update_approved'))
                                                @if ($item->approved == 1)
                                                    <td>
                                                        <select name="the_device_status[{{ $the_device->id }}]"
                                                            class="form-control">
                                                            <option value="0"
                                                                {{ $the_device->status == '0' ? 'selected' : '' }}>
                                                                Chưa trả
                                                            </option>
                                                            <option value="1"
                                                                {{ $the_device->status == '1' ? 'selected' : '' }}>Đã
                                                                trả
                                                            </option>
                                                        </select>

                                                    </td>
                                                @endif
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table><!-- /.table -->
                                <div class="form-actions">
                                    <a href="{{ route('borrows.index') }}" class="btn btn-secondary float-right">
                                        Quay lại
                                    </a>
                                        <button class="btn btn-primary ml-auto" type="submit">Lưu</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div><!-- /.card-body -->
        </div>
    </div>
@endsection
