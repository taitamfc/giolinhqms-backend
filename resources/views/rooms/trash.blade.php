@extends('layouts.master')
@section('content')
    <header class="page-title-bar">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <a href="{{ route('rooms.index') }}"><i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Trang Chủ</a>
                </li>
            </ol>
        </nav>
        <div class="d-md-flex align-items-md-start">
            <h1 class="page-title mr-sm-auto">Quản Lý Lớp Học - Thùng Rác</h1>
            <div class="btn-toolbar">
            </div>
        </div>
    </header>
    <div class="page-section">
        <div class="card card-fluid">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link " href="{{ route('rooms.index') }}">Tất Cả</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active " href="{{ route('rooms.trash') }}">Thùng Rác</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col">
                        <form action="{{ route('rooms.trash') }}" method="GET" id="form-search">
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
                                <th> Tên Lớp Học </th>
                                <th> Thao Tác </th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rooms as $room)
                                <tr>
                                    <td class="align-middle"> {{ $room->id }} </td>
                                    <td class="align-middle"> {{ $room->name }} </td>
                                    <td>
                                        {{-- @if (Auth::user()->hasPermission('Customer_forceDelete')) --}}
                                        <form action="{{ route('rooms.force_destroy', $room->id) }}" style="display:inline"
                                            method="post">
                                            <button onclick="return confirm('Xóa vĩnh viễn {{ $room->name }} ?')"
                                                class="btn btn-sm btn-icon btn-secondary"><i
                                                    class="far fa-trash-alt"></i></button>
                                            @csrf
                                            @method('delete')
                                        </form>
                                        {{-- @endif --}}

                                        {{-- @if (Auth::user()->hasPermission('Customer_restore')) --}}
                                        <span class="sr-only">Edit</span></a> <a
                                            href="{{ route('rooms.restore', $room->id) }}"
                                            class="btn btn-sm btn-icon btn-secondary"><i class="fa fa-trash-restore"></i>
                                            <span class="sr-only">Remove</span></a>
                                        {{-- @endif --}}
                                    </td>
                                </tr><!-- /tr -->
                            @endforeach
                        </tbody><!-- /tbody -->
                    </table><!-- /.table -->
                    <div style="float:right">
                        {{ $rooms->appends(request()->query())->links() }}
                    </div>
                </div>
                <!-- /.table-responsive -->
                <!-- .pagination -->
            </div><!-- /.card-body -->
        </div>
    </div>
@endsection
