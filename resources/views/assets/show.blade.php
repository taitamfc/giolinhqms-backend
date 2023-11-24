@extends('layouts.master')
@section('content')
<header class="page-title-bar">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">
                <a href="{{ route('assets.index') }}"><i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Trang Chủ</a>
            </li>
        </ol>
    </nav>
    <div class="d-md-flex align-items-md-start">
        <h1 class="page-title mr-sm-auto">Chi tiết tài sản</h1>
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
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-bordered">
                        <thead class="thead-">
                            <tr>
                                <th colspan="2">Thông tin tài sản</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td> Tên </td>
                                <td> {{ $item->name }}</td>
                            </tr>
                            <tr>
                                <td> Số lượng </td>
                                <td> {{ $item->quantity }} </td>
                            </tr>
                            <tr>
                                <td> Loại thiết bị </td>
                                <td> {{ $item->devicetype->name }} </td>
                            </tr>
                            <tr>
                                <td> Giá </td>
                                <td> {{ number_format($item->price, 0, ',', '.') }} VND </td>
                            </tr>
                            <tr>
                                <td> Bộ môn </td>
                                <td> {{ $item->department->name }} </td>
                            </tr>
                            <tr>
                                <td> Phân Loại </td>
                                <td> {{ $item->type }} </td>
                            </tr>
                            <tr>
                                <td> Loại thiết bị </td>
                                <td> {{ $item->price }} </td>
                            </tr>
                            <tr>
                                <td> Năm sản xuất </td>
                                <td> {{ $item->year_born }} </td>
                            </tr>
                            <tr>
                                <td> Đơn vị </td>
                                <td> {{ $item->unit }} </td>
                            </tr>
                            <tr>
                                <td> Ghi chú </td>
                                <td> {{ $item->note }} </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- /.card-body -->
    </div>
</div>
@endsection