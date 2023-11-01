@extends('layouts.master')
@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


    <header class="page-title-bar">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <a href="{{ route('managedevices.index') }}"><i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Trang
                        Chủ</a>
                </li>
            </ol>
        </nav>
        <div class="d-md-flex align-items-md-start">
            <h1 class="page-title mr-sm-auto">Sổ Quản Lý Thiết Bị</h1>
            <div class="btn-toolbar">
                {{-- managedevices.testHTML --}}
                {{-- export.single.page --}}
                <!-- <a href="{{ route('export.single.page') }}?{{ $current_url }}" id="exportExcel" class="btn btn-primary mr-2">
                    <i class="fa-solid fa fa-plus"></i>
                    <span class="ml-1">Xuất Excel</span>
                </a> -->

            </div>
        </div>
    </header>
    <div class="page-section">
        <div class="card card-fluid">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('managedevices.index') }}">Tất Cả</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col">
                        <form action="{{ route('managedevices.index') }}" method="GET" id="form-search">
                            <div class="row">
                                <div class="col">
                                    <label>Tên giáo viên</label>
                                    <select name="searchTeacher" class="form-control">
                                        <option value="">Chọn giáo viên</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ request('searchTeacher') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col">
                                    <label>Tên thiết bị</label>
                                    <input name="searchName" value="{{ request('searchName') }}" class="form-control"
                                        type="text" placeholder="Tên thiết bị..." />
                                </div>
                                <div class="col">
                                    <label>Buổi</label>
                                    <select name="searchSession" class="form-control">
                                        <option value="">Buổi...</option>
                                        <option value="Sáng" {{ request('searchSession') == 'Sáng' ? 'selected' : '' }}>
                                            Sáng
                                        </option>
                                        <option value="Chiều" {{ request('searchSession') == 'Chiều' ? 'selected' : '' }}>
                                            Chiều
                                        </option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label>Năm học</label>
                                    <select name="searchSchoolYear" class="form-control">
                                        <option value="">Năm học</option>
                                        @php
                                            $currentYear = 2022;
                                            $selectedYear = request('searchSchoolYear'); // Lấy giá trị từ request

                                            for ($year = $currentYear; $year <= 2050; $year++) {
                                                $nextYear = $year + 1;
                                                $schoolYear = "$year - $nextYear";

                                                // Kiểm tra nếu giá trị của tùy chọn khớp với giá trị từ request
                                                $selected = $schoolYear == $selectedYear ? 'selected' : '';

                                                echo "<option value=\"$schoolYear\" $selected>$schoolYear</option>";
                                            }
                                        @endphp
                                    </select>
                                </div>


                                <div class="col">
                                    <label>Ngày dạy từ</label>
                                    <input name="searchBorrow_date" value="{{ request('searchBorrow_date') }}"
                                        class="form-control" type="date" placeholder="Ngày dạy từ..." />
                                </div>
                                <div class="col">
                                    <label>Ngày dạy đến</label>
                                    <input name="searchBorrow_date_to" value="{{ request('searchBorrow_date_to') }}"
                                        class="form-control" type="date" placeholder="Ngày dạy đến..." />
                                </div>
                                <div class="col">
                                    <label>Trạng thái</label>
                                    <select name="searchStatus" class="form-control">
                                        <option value="">Trạng thái...</option>
                                        <option value="1" {{ request('searchStatus') == '1' ? 'selected' : '' }}>Đã
                                            trả
                                        </option>
                                        <option value="0" {{ request('searchStatus') == '0' ? 'selected' : '' }}>Chưa
                                            trả</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label>Tổ</label>
                                    <select name="searchNest" class="form-control">
                                        <option value="">Tổ...</option>
                                        @foreach ($nests as $nest)
                                            <option value="{{ $nest->id }}"
                                                {{ request('searchNest') == $nest->id ? 'selected' : '' }}>
                                                {{ $nest->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-auto" style="margin-top: 1.8rem;">
                                    <button class="btn btn-secondary" type="submit">Tìm Kiếm</button>
                                </div>
                            </div>
                    </div>
                </div>
                </form>
            </div>
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Người mượn</th>
                            <th>Thiết bị</th>
                            <th>Bài dạy</th>
                            <th>Số lượng</th>
                            <th>Buổi</th>
                            <th>PCCT</th>
                            <th>Lớp</th>
                            <th>TKB</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo phiếu</th>
                            <th>Ngày dạy</th>
                            <th>Ngày trả</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $key => $item)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $item->borrow->user->name ?? '(Phiếu mượn đã bị xóa)' }}</td>

                                <td>{{ $item->device->name ?? '(Không xác định)' }}</td>
                                <td>{{ $item->lesson_name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->session }}</td>
                                <td>{{ $item->lecture_name }}</td>
                                <td>{{ $item->room ? $item->room->name : '' }}</td>
                                <td>{{ $item->lecture_number }}</td>
                                <td>{{ $changeStatus[$item->status] ?? '(Không xác định)' }}</td>
                                <td>
                                    {{ optional($item->borrow)->created_at ? date('d/m/Y H:i:s', strtotime($item->borrow->created_at)) : '(Không xác định)' }}
                                </td>
                                <td>
                                    {{ optional($item->borrow)->borrow_date ? date('d/m/Y', strtotime($item->borrow->borrow_date)) : '(Không xác định)' }}
                                </td>
                                <td>{{ $item->return_date ? date('d/m/Y', strtotime($item->return_date)) : '' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="float:right">
                    {{ $items->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    @endsection
