@extends('layouts.master')
@section('content')
<header class="page-title-bar">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">
                <a href="{{ route('assets.index') }}"><i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Trang
                    Chủ</a>
            </li>
        </ol>
    </nav>
    <!-- <button type="button" class="btn btn-success btn-floated"><span class="fa fa-plus"></span></button> -->
    <div class="d-md-flex align-items-md-start">
        <h1 class="page-title mr-sm-auto">Quản Lý Tài Sản</h1>
        <div class="btn-toolbar">
            @if (Auth::user()->hasPermission('Asset_create'))
            <a href="{{ route('assets.create') }}" class="btn btn-primary mr-2">
                <i class="fa-solid fa fa-plus"></i>
                <span class="ml-1">Thêm Mới</span>
            </a>
            <a href="{{ route('assets.getImport') }}" class="btn btn-primary mr-2">
                <i class="fa-solid fa fa-arrow-down"></i>
                <span class="ml-1">Import Excel</span>
            </a>
            <a href="{{ route('assets.export') }}" class="btn btn-primary mr-2">
                <i class="fa-solid fa fa-arrow-up"></i>
                <span class="ml-1">Export Excel</span>
            </a>
            @endif
        </div>
    </div>
</header>
<div class="page-section">
    <div class="card card-fluid">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link active " href="{{ route('assets.index') }}">Tất Cả</a>
                </li>
                @if (Auth::user()->hasPermission('Asset_trash'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('assets.trash') }}">Thùng Rác</a>
                </li>
                @endif
            </ul>
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col">
                    <form action="{{ route('assets.index') }}" method="GET" id="form-search">
                        <div class="row">
                            <div class="col">
                                <input name="searchName" value="{{ request('searchName') }}" class="form-control"
                                    type="text" placeholder=" tên..." />
                            </div>
                            <div class="col">
                                <select name="searchDevicetype" class="form-control">
                                    <option value=""> Loại Thiết Bị...</option>
                                    @foreach ($devicetypes as $key => $devicetype)
                                    <option value="{{ $devicetype->id }} "
                                        {{ $request->searchDevicetype == $devicetype->id ? 'selected' : '' }}>
                                        {{ $devicetype->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <select name="searchQuantity" class="form-control">
                                    <option value="">Tình trạng</option>
                                    <option value="2" {{ $request->searchQuantity == 2 ? 'selected' : '' }}>Còn
                                        thiết bị</option>
                                    <option value="1" {{ $request->searchQuantity == 1 ? 'selected' : '' }}>Hết
                                        thiết bị</option>
                                </select>
                            </div>
                            <div class="col">
                                <select name="searchDepartment" class="form-control">
                                    <option value=""> Bộ môn...</option>
                                    @foreach ($departments as $department)
                                    <option value="{{ $department->id }}"
                                        {{ $request->searchDepartment == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <button class="btn btn-secondary" type="submit">Tìm Kiếm</button>
                            </div>
                        </div>
                    </form>
                </div>
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
                            <th>STT</th>
                            <th>Tên thiết bị</th>
                            <th>Số lượng</th>
                            <th>Loại thiết bị</th>
                            <th>Bộ môn</th>
                            <th>Chức năng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $key => $item)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>
                                <a href="{{ route('assets.edit', $item->id) }}" class="tile tile-img mr-1">
                                    <img class="img-fluid" src="{{ asset($item->image) }}" alt="">
                                </a>
                                @if (Auth::user()->hasPermission('Asset_view'))
                                <a href="{{ route('assets.edit', $item->id) }}">{{ $item->name }}</a>
                                @else
                                {{ $item->name }}
                                @endif
                            </td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->devicetype->name }}</td>
                            <td>{{ $item->department ? $item->department->name : null }}</td>
                            <td>
                                @if (Auth::user()->hasPermission('Asset_view'))
                                <a title="Xem" class="btn btn-sm btn-icon btn-secondary"
                                    href="{{ route('assets.show', $item->id) }}">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                @endif
                                @if (Auth::user()->hasPermission('Asset_delete'))
                                <form action="{{ route('assets.destroy', $item->id) }}" style="display:inline"
                                    method="post">
                                    <button onclick="return confirm('Xóa {{ $item->name }} ?')"
                                        class="btn btn-sm btn-icon btn-secondary"><i
                                            class="far fa-trash-alt"></i></button>
                                    @csrf
                                    @method('delete')
                                </form>
                                @endif
                                @if (Auth::user()->hasPermission('Asset_update'))
                                <span class="sr-only">Edit</span></a> <a href="{{ route('assets.edit', $item->id) }}"
                                    class="btn btn-sm btn-icon btn-secondary"><i class="fa fa-pencil-alt"></i>
                                    <span class="sr-only">Remove</span></a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="float:right">
                    {{ $items->appends(request()->query())->links() }}
                </div>
            </div>
            @endsection