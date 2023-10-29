@extends('layouts.master')
@section('content')
    <header class="page-title-bar">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <a href="{{ route('devices.index') }}"><i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Trang Chủ</a>
                </li>
            </ol>
        </nav>
        <!-- <button type="button" class="btn btn-success btn-floated"><span class="fa fa-plus"></span></button> -->
        <div class="d-md-flex align-items-md-start">
            <h1 class="page-title mr-sm-auto">Quản Lý Thiết Bị - Thùng Rác</h1>
            <div class="btn-toolbar">
            </div>
        </div>
    </header>
    <div class="page-section">
        <div class="card card-fluid">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link " href="{{ route('devices.index') }}">Tất Cả</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active " href="{{ route('devices.trash') }}">Thùng Rác</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col">
                        <form action="{{ route('devices.trash') }}" method="GET" id="form-search">
                            <div class="row">
                                <div class="col">
                                    <input name="searchName" value="{{request('searchName')}}" class="form-control" type="text"
                                        placeholder=" tên..." />
                                </div>
                                <div class="col">
                                    <select name="searchDevicetype"  class="form-control">
                                        <option value=""> Loại Thiết Bị...</option>
                                        @foreach ($devicetypes as $key => $devicetype)
                                        <option value="{{ $devicetype->id }}" {{ $request->searchDevicetype == $devicetype->id ? 'selected' : '' }}> {{ $devicetype->name }} </option>
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
                @if (Session::has('success'))
                    <div class="alert alert-success">{{ session::get('success') }}</div>
                @endif
                @if (Session::has('error'))
                    <div class="alert alert-danger">{{ session::get('error') }}</div>
                @endif
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên </th>
                                <th>Số lượng</th>
                                <th>Loại thiết bị</th>
                                <th>Ảnh</th>
                                <th>Chức năng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $key => $item)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->devicetype->name }}</td>
                                    <td>
                                        <a href="#" class="tile tile-img mr-1">
                                            <img class="img-fluid" src="{{ asset($item->image) }}" alt="">
                                        </a>
                                    </td>
                                    <td>
                                        <form action="{{ route('devices.forceDelete', $item->id) }}" style="display:inline"
                                            method="post">
                                            <button onclick="return confirm('Xóa vĩnh viễn {{ $item->name }} ?')"
                                                class="btn btn-sm btn-icon btn-secondary"><i
                                                    class="far fa-trash-alt"></i></button>
                                            @csrf
                                            @method('delete')
                                        </form>
                                        <span class="sr-only">Edit</span></a> <a
                                            href="{{ route('devices.restore', $item->id) }}"
                                            class="btn btn-sm btn-icon btn-secondary"><i class="fa fa-trash-restore"></i>
                                            <span class="sr-only">Remove</span></a>
                                    </td>
                            @endforeach
                            </tr>
                        </tbody>
                    </table>
                    <div style="float:right">
                        {{ $items->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
