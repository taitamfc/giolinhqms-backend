@extends('layouts.master')
@section('content')
    <header class="page-title-bar">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <a href="{{ route('users.index') }}"><i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Trang Chủ</a>
                </li>
            </ol>
        </nav>
        <div class="d-md-flex align-items-md-start">
            <h1 class="page-title mr-sm-auto">Quản Lý Giáo Viên - Thùng Rác</h1>
            <div class="btn-toolbar">
            </div>
        </div>
    </header>
    <div class="page-section">
        <div class="card card-fluid">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link " href="{{ route('users.index') }}">Tất Cả</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active " href="{{ route('users.trash') }}">Thùng Rác</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col">
                        <form action="{{ route('users.trash') }}" method="GET" id="form-search">
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
                                <th>ID</th>
                                <th>Tên</th>
                                <th>E-mail</th>
                                <th>Địa chỉ</th>
                                <th>Số điện thoại</th>
                                <th>Chức năng</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>
                                        <a href="#" class="tile tile-img mr-1">
                                            <img class="img-fluid" src="{{ asset($user->image) }}" alt="">
                                        </a>
                                        {{ $user->name }}
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->address }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>
                                        {{-- @if (Auth::user()->hasPermission('Customer_forceDelete')) --}}
                                        <form action="{{ route('users.force_destroy', $user->id) }}" style="display:inline"
                                            method="post">
                                            <button onclick="return confirm('Xóa vĩnh viễn {{ $user->name }} ?')"
                                                class="btn btn-sm btn-icon btn-secondary"><i
                                                    class="far fa-trash-alt"></i></button>
                                            @csrf
                                            @method('delete')
                                        </form>
                                        {{-- @endif --}}

                                        {{-- @if (Auth::user()->hasPermission('Customer_restore')) --}}
                                        <span class="sr-only"></span></a> <a href="{{ route('users.restore', $user->id) }}"
                                            class="btn btn-sm btn-icon btn-secondary"><i class="fa fa-trash-restore"></i>
                                            <span class="sr-only"></span></a>
                                        {{-- @endif --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div style="float:right">
                        {{ $users->appends(['search' => $request->search])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
