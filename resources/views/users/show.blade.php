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
            <h1 class="page-title mr-sm-auto">Xem thông tin chi tiết giáo viên : {{ $item->name }}</h1>
        </div>
    </header>
    <div class="page-section">
        <div class="row">
            <div class="col-lg-4">
                <div class="card card-fluid">
                    <h6 class="card-header"> Chi tiết </h6>
                    <nav class="nav nav-tabs flex-column border-0">
                        <a href="{{ route('users.show', $item->id) }}" class="nav-link active">Chi tiết giáo
                            viên</a>
                        <a href="{{ route('users.borrow_history', $item->id) }}" class="nav-link">Lịch sử
                            mượn</a>
                    </nav>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card card-fluid">
                    <h6 class="card-header"> Hồ sơ công khai </h6>
                    <div class="card-body">
                        <div class="media mb-3">
                            <div class="user-avatar user-avatar-xl fileinput-button">
                                    <img src="{{ asset($item->image) }}" alt="">
                            </div>
                            <div class="media-body pl-3">
                                <div id="progress-avatar" class="progress progress-xs fade">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                        role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                        <form method="post">
                            <div class="form-row">
                                <label for="input01" class="col-md-3">Tên giáo viên :</label>

                                <div class="col-md-9 mb-3">
                                    <div class="custom-file">
                                        <p>{{ $item->name }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <label for="input02" class="col-md-3">E-mail :</label>
                                <div class="col-md-9 mb-3">
                                    <p>{{ $item->email }}</p>
                                </div>
                            </div>
                            <div class="form-row">
                                <label for="input03" class="col-md-3">Số điện thoại :</label>
                                <div class="col-md-9 mb-3">
                                    <p>{{ $item->phone }}</p>
                                </div>
                            </div>
                            <div class="form-row">
                                <label for="input04" class="col-md-3">Địa chỉ :</label>
                                <div class="col-md-9 mb-3">
                                    <p>{{ $item->address }}</p>
                                </div>
                            </div>
                            <div class="form-row">
                                <label for="input04" class="col-md-3">Giới tính :</label>
                                <div class="col-md-9 mb-3">
                                    <p>{{ $item->gender }}</p>
                                </div>
                            </div>
                            <div class="form-row">
                                <label for="input04" class="col-md-3">Ngày sinh :</label>
                                <div class="col-md-9 mb-3">
                                    <p>{{ date('d/m/Y', strtotime($item->birthday)) }}</p>

                                </div>
                            </div>
                            <div class="form-row">
                                <label for="input04" class="col-md-3">Chức vụ :</label>
                                <div class="col-md-9 mb-3">
                                    <p>{{ $item->group->name }}</p>
                                </div>
                            </div>
                            <div class="form-row">
                                <label for="input04" class="col-md-3">Tổ :</label>
                                <div class="col-md-9 mb-3">
                                    <p>{{ $item->nest->name }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="form-actions">
                                <a class="btn btn-dark" href="{{ route('users.index') }}">
                                    <i class="fa fa-arrow-left mr-2"></i> Quay lại
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
