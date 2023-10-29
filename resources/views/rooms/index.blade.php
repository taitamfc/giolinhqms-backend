@extends('layouts.master')
@section('content')
    <header class="page-title-bar">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <a href="{{ route('rooms.index') }}"><i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Trang
                        Chủ</a>
                </li>
            </ol>
        </nav>
        <div class="d-md-flex align-items-md-start">
            <h1 class="page-title mr-sm-auto">Quản Lý Lớp Học</h1>
            <div class="btn-toolbar">
                @if (Auth::user()->hasPermission('Room_create'))
                    <a href="{{ route('rooms.create') }}" class="btn btn-primary mr-2">
                        <i class="fa-solid fa fa-plus"></i>
                        <span class="ml-1">Thêm Mới</span>
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
                        <a class="nav-link active " href="{{ route('rooms.index') }}">Tất Cả</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('rooms.trash') }}">Thùng Rác</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col">
                        <form action="{{ route('rooms.index') }}" method="GET" id="form-search">
                            <div class="row">
                                <div class="col">

                                    <input name="search" value="{{request('search')}}" class="form-control" type="text"
                                        placeholder=" tên..." />
                                </div>
                                <div class="col-lg-1">
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
                                <th> Tên lớp học </th>
                                @if (Auth::check())
                                    <th> Chức năng </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rooms as $room)
                                <tr>
                                    <td class="align-middle"> {{ $room->id }} </td>
                                    <td class="align-middle"> {{ $room->name }} </td>
                                    @if (Auth::check())
                                        <td>
                                            @if (Auth::user()->hasPermission('Room_update'))
                                                <form action="{{ route('rooms.destroy', $room->id) }}"
                                                    style="display:inline" method="post">
                                                    <button onclick="return confirm('Xóa {{ $room->name }} ?')"
                                                        class="btn btn-sm btn-icon btn-secondary"><i
                                                            class="far fa-trash-alt"></i></button>
                                                    @csrf
                                                    @method('delete')
                                                </form>
                                            @endif

                                            @if (Auth::user()->hasPermission('Room_delete'))
                                                <span class="sr-only">Edit</span></a> <a
                                                    href="{{ route('rooms.edit', $room->id) }}"
                                                    class="btn btn-sm btn-icon btn-secondary"><i
                                                        class="fa fa-pencil-alt"></i> <span
                                                        class="sr-only">Remove</span></a>
                                            @endif
                                        </td>
                                    @endif
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
