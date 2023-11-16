@extends('layouts.master')
@section('content')
    <header class="page-title-bar">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <a href="{{ route('departments.index') }}"><i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Trang
                        Chủ</a>
                </li>
            </ol>
        </nav>
        <div class="d-md-flex align-items-md-start">
            <h1 class="page-title mr-sm-auto">Quản Lý Bộ Môn</h1>
            <div class="btn-toolbar">
                @if (Auth::user()->hasPermission('Department_create'))
                    <a href="{{ route('departments.create') }}" class="btn btn-primary mr-2">
                        <i class="fa-solid fa fa-plus"></i>
                        <span class="ml-1">Thêm Mới</span>
                    </a>
                    <a href="{{ route('departments.getImport') }}" class="btn btn-primary mr-2">
                        <i class="fa-solid fa fa-arrow-down"></i>
                        <span class="ml-1">Import Excel</span>
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
                        <a class="nav-link active " href="{{ route('departments.index') }}">Tất Cả</a>
                    </li>
                    @if (Auth::user()->hasPermission('Department_trash'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('departments.trash') }}">Thùng Rác</a>
                        </li>
                    @endif
                </ul>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col">
                        <form action="{{ route('departments.index') }}" method="GET" id="form-search">
                            <div class="row">
                                <div class="col">
                                    <input name="searchname" value="{{ request('searchname') }}" class="form-control"
                                        type="text" placeholder=" tên..." />
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
                                <th> STT </th>
                                <th> Tên bộ môn </th>
                                <th> Chức năng </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($departments as $item)
                                <tr>
                                    <td class="align-middle"> {{ $item->id }} </td>
                                    <td class="align-middle"> {{ $item->name }} </td>

                                    <td>
                                        @if (Auth::user()->hasPermission('Department_delete'))
                                            <form action="{{ route('departments.destroy', $item->id) }}"
                                                style="display:inline" method="post">
                                                <button onclick="return confirm('Xóa {{ $item->name }} ?')"
                                                    class="btn btn-sm btn-icon btn-secondary"><i
                                                        class="far fa-trash-alt"></i></button>
                                                @csrf
                                                @method('delete')
                                            </form>
                                        @endif
                                        @if (Auth::user()->hasPermission('Department_update'))
                                            <span class="sr-only">Edit</span></a> <a
                                                href="{{ route('departments.edit', $item->id) }}"
                                                class="btn btn-sm btn-icon btn-secondary"><i class="fa fa-pencil-alt"></i>
                                                <span class="sr-only">Remove</span></a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div style="float:right">
                        {{ $departments->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
