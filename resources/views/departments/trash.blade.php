@extends('layouts.master')
@section('content')
    <header class="page-title-bar">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <a href="{{ route('departments.index') }}"><i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Trang Chủ</a>
                </li>
            </ol>
        </nav>
        <div class="d-md-flex align-items-md-start">
            <h1 class="page-title mr-sm-auto">Quản Lý Bộ Môn - Thùng Rác</h1>
            <div class="btn-toolbar">
            </div>
        </div>
    </header>
    <div class="page-section">
        <div class="card card-fluid">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link " href="{{ route('departments.index') }}">Tất Cả</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active " href="{{ route('departments.trash') }}">Thùng Rác</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col">
                        <form action="{{ route('departments.trash') }}" method="GET" id="form-search">
                            <div class="row">
                                <div class="col">
                                    <input name="search" class="form-control" type="text"
                                    value="{{ request('search') }}" placeholder=" tên..." />
                                </div>
                                <div class="col-lg-1">
                                    <button class="btn btn-secondary" data-toggle="modal" data-target="#modalSaveSearch"
                                        type="submit">Tìm Kiếm</button>
                                </div>
                            </div>
                            <!-- modalFilterColumns  -->
                            {{-- @include('admin.customers.modals.modalFilterColumns') --}}
                        </form>
                        <!-- modalFilterColumns  -->
                        {{-- @include('admin.customers.modals.modalSaveSearch') --}}
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
                                <th> Tên Bộ Môn </th>
                                <th> Thao Tác </th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($departments as $department)
                                <tr>
                                    <td class="align-middle"> {{ $department->id }} </td>
                                    <td class="align-middle"> {{ $department->name }} </td>
                                    <td>
                                        {{-- @if (Auth::user()->hasPermission('Customer_forceDelete')) --}}
                                        <form action="{{ route('departments.force_destroy', $department->id) }}" style="display:inline"
                                            method="post">
                                            <button onclick="return confirm('Xóa vĩnh viễn {{ $department->name }} ?')"
                                                class="btn btn-sm btn-icon btn-secondary"><i
                                                    class="far fa-trash-alt"></i></button>
                                            @csrf
                                            @method('delete')
                                        </form>
                                        {{-- @endif --}}

                                        {{-- @if (Auth::user()->hasPermission('Customer_restore')) --}}
                                        <span class="sr-only">Edit</span></a> <a
                                            href="{{ route('departments.restore', $department->id) }}"
                                            class="btn btn-sm btn-icon btn-secondary"><i class="fa fa-trash-restore"></i>
                                            <span class="sr-only">Remove</span></a>
                                        {{-- @endif --}}
                                    </td>
                                </tr><!-- /tr -->
                            @endforeach
                        </tbody><!-- /tbody -->
                    </table><!-- /.table -->
                    <div style="float:right">
                        {{ $departments->appends(request()->query())->links() }}
                    </div>
                </div>
                <!-- /.table-responsive -->
                <!-- .pagination -->
            </div><!-- /.card-body -->
        </div>
    </div>
@endsection
