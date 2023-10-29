@extends('layouts.master')
@section('content')
<!-- .page-title-bar -->
<header class="page-title-bar">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">
                <a href="{{route('rooms.index')}}"><i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Quản Lý Lớp Học</a>
            </li>
        </ol>
    </nav>
    <h1 class="page-title"> Chỉnh Sửa Lớp Học </h1>
</header>

<div class="page-section">
    <form method="post" action="{{route('rooms.update',$room->id)}}">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-body">
                <legend>Thông tin cơ bản</legend>
                <!-- <form method="post" action="{{route('rooms.update',$room->id)}}">
                    @csrf
                    @method('PUT') -->
                <div class="form-group">
                    <label for="tf1">Tên lớp học</label> <input type="text" name="name" value="{{ $room->name }}" class="form-control" placeholder="Nhập tên lớp học"> 
                    <small class="form-text text-muted"></small>
                    @if ($errors->any())
                    <p style="color:red">{{ $errors->first('name') }}</p>
                    @endif
                </div>
               
                <div class="form-actions">
                    <a class="btn btn-secondary float-right" href="{{route('rooms.index')}}">Hủy</a>
                    <button class="btn btn-primary ml-auto" type="submit">Cập nhật</button>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection