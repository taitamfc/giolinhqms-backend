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
            <h1 class="page-title mr-sm-auto">Quản Lý Quyền</h1>
            <div class="btn-toolbar">
                @if (Auth::user()->hasPermission('Group_create'))
                    <a href="{{ route('groups.create') }}" class="btn btn-primary mr-2">
                        <i class="fa-solid fa fa-plus"></i>
                        <span class="ml-1">Thêm Mới</span>
                    </a>
                @endif
            </div>
        </div>
    </header>
    <div class="page-section">
        <div class="card card-fluid">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col">
                        <form action="{{ route('groups.index') }}" method="GET" id="form-search">
                            <div class="row">
                                <div class="col">
                                    <input name="search" value="{{request('search')}}" class="form-control" type="text"
                                        placeholder=" tên..." />
                                </div>
                                <div class="col-lg-2">
                                    <button class="btn btn-secondary" data-toggle="modal" data-target="#modalSaveSearch"
                                        type="submit">Tìm Kiếm</button>
                                </div>
                        </form>
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
                        <th>Nhân Sự</th>
                        <th>Chức Năng</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $key => $item)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $item->name }}</td>
                            <td>Hiện có {{ count($item->users) }} người</td>
                            </td>
                            <td>
                                @if (Auth::user()->hasPermission('Group_update'))
                                    <span class="sr-only">Edit</span></a> <a href="{{ route('groups.edit', $item->id) }}"
                                        class="btn btn-sm btn-icon btn-secondary"><i class="fa fa-pencil-alt"></i>
                                        <span class="sr-only">Remove</span></a>
                                @endif
                                @if (Auth::user()->hasPermission('Group_delete'))
                                    <form action="{{ route('groups.destroy', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Bạn có muốn xóa không ?')"
                                            class="btn btn-sm btn-icon btn-secondary"><i
                                                class="far fa-trash-alt"></i></button>
                                        <a class="btn btn-sm btn-icon btn-secondary"
                                            href="{{ route('groups.show', $item->id) }}">
                                            <i class="fa-solid fa-user-tie"></i></a>

                                    </form>
                                @endif
                            </td>

                        </tr>
                    @endforeach
                </tbody>
                <!-- /tbody -->
            </table><!-- /.table -->

            <div style="float:right">
                {{ $items->appends(request()->query())->links() }}
            </div>

        </div>
        <!-- /.table-responsive -->
        <!-- .pagination -->

    </div><!-- /.card-body -->
    </div>
    </div>
@endsection
