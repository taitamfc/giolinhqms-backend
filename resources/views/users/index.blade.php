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
        <h1 class="page-title mr-sm-auto">Quản Lý Giáo Viên</h1>
        <div class="btn-toolbar">
            @if (Auth::user()->hasPermission('User_create'))
            <a href="{{ route('users.create') }}" class="btn btn-primary mr-2">
                <i class="fa-solid fa fa-plus"></i>
                <span class="ml-1">Thêm Mới</span>
            </a>
            <a href="{{ route('users.getImport') }}" class="btn btn-primary mr-2">
                <i class="fa-solid fa fa-arrow-down"></i>
                <span class="ml-1">Import Excel</span>
            </a>
            <a href="{{ route('users.export') }}" class="btn btn-primary mr-2">
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
                    <a class="nav-link active " href="{{ route('users.index') }}">Tất Cả</a>
                </li>
                @if (Auth::user()->hasPermission('User_trash'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('users.trash') }}">Thùng Rác</a>
                </li>
                @endif
            </ul>
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col">
                    <form action="{{ route('users.index') }}" method="GET" id="form-search">
                        <div class="row">
                            <div class="col">
                                <input name="searchname" class="form-control" type="text" placeholder=" tên..."
                                    value="{{ request('searchname') }}" />
                            </div>
                            <div class="col">
                                <input name="searchemail" class="form-control" type="text" placeholder=" E-mail..."
                                    value="{{ request('searchemail') }}" />
                            </div>
                            <div class="col">
                                <input name="searchphone" class="form-control" type="text"
                                    placeholder=" số điện thoại..." value="{{ request('searchphone') }}" />
                            </div>
                            <div class="col">
                                <select name="searchGroup" class="form-control">
                                    <option value=""> chức vụ...</option>
                                    @foreach ($groups as $key => $group)
                                    <option value="{{ $group->id }}"
                                        {{ $request->searchGroup == $group->id ? 'selected' : '' }}>
                                        {{ $group->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <select name="searchNest" class="form-control">
                                    <option value=""> tổ...</option>
                                    @foreach ($nests as $key => $nest)
                                    <option value="{{ $nest->id }}"
                                        {{ $request->searchNest == $nest->id ? 'selected' : '' }}>
                                        {{ $nest->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <button class="btn btn-secondary" data-toggle="modal" data-target="#modalSaveSearch"
                                    type="submit">Tìm Kiếm</button>
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
                            <th>Tên</th>
                            <th>E-mail</th>
                            <th>Địa chỉ</th>
                            <th>Số điện thoại</th>
                            <th>Chức vụ</th>
                            <th>Tổ</th>
                            @if (Auth::check())
                            <th>Chức năng</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $key => $item)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>
                                <a href="#" class="tile tile-img mr-1">
                                    <img class="img-fluid" src="{{ asset($item->image) }}" alt="">
                                </a>
                                @if (Auth::user()->hasPermission('User_view'))
                                <a href="{{ route('users.show', $item->id) }}">{{ $item->name }}</a>
                                @else
                                {{ $item->name }}
                                @endif
                            </td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->address }}</td>
                            <td>{{ $item->phone }}</td>
                            <td>{{ $item->group->name }}</td>
                            <td>{{ $item->nest->name }}</td>
                            @if (Auth::check())
                            <td>
                                @if (Auth::user()->hasPermission('User_update'))
                                <span class="sr-only">Edit</span></a> <a href="{{ route('users.edit', $item->id) }}"
                                    class="btn btn-sm btn-icon btn-secondary"><i class="fa fa-pencil-alt"></i> <span
                                        class="sr-only">Remove</span></a>
                                @endif
                                @if (Auth::user()->hasPermission('User_delete'))
                                <form action="{{ route('users.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Bạn có muốn xóa không ?')"
                                        class="btn btn-sm btn-icon btn-secondary"><i class="far fa-trash-alt"></i>
                                    </button>
                                </form>
                                @endif
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div style="float:right">
                    {{ $items->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection