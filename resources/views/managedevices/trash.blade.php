@extends('layouts.master')
@section('content')
<header class="page-title-bar">
   <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
         <li class="breadcrumb-item active">
            <a href="{{route('managedevices.index')}}"><i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Trang Chủ</a>
         </li>
      </ol>
   </nav>
   <!-- <button type="button" class="btn btn-success btn-floated"><span class="fa fa-plus"></span></button> -->
   <div class="d-md-flex align-items-md-start">
      <h1 class="page-title mr-sm-auto">Chi Tiết Phiếu Mượn - Thùng Rác</h1>
      <div class="btn-toolbar">
      </div>
   </div>
</header>
<div class="page-section">
   <div class="card card-fluid">
      <div class="card-header">
         <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
               <a class="nav-link " href="{{route('managedevices.index')}}">Tất Cả</a>
            </li>
            <li class="nav-item">
               <a class="nav-link active " href="{{route('managedevices.trash')}}">Thùng Rác</a>
            </li>
         </ul>
      </div>
      <div class="card-body">
         <div class="row mb-2">
            <div class="col">
            </div>
         </div>
         @if (Session::has('success'))
         <div class="alert alert-success">{{session::get('success')}}</div>
         @endif
         @if (Session::has('error'))
         <div class="alert alert-danger">{{session::get('error')}}</div>
         @endif
         <div class="table-responsive">
            <table class="table">
               <thead>
                  <tr>
                            <th>#</th>
                            <th>Người mượn</th>
                            <th>Tên thiết bị</th>
                            <th>Tên bài dạy</th>
                            <th>Số lượng</th>
                            <th>Buổi</th>
                            <th>Tiết PCCT</th>
                            <th>Lớp</th>
                            <th>Tiết TKB</th>
                            <th>Ngày dạy</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($items  as $key => $item)
                  <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $item->borrow->user->name ?? 'Người mượn không tồn tại' }}</td>
                            <td>{{ $item->device->name }}</td>
                            <td>{{ $item->lesson_name }}</td>
                            <td>{{ $item->device_id }}</td>
                            <td>{{ $item->session }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->room->name }}</td>
                            <td>{{ $item->lecture_name	 }}</td>
                            <td>{{ $item->return_date}}</td>
                     <td>
                        <form action="{{ route('managedevices.forceDelete',$item->id )}}" style="display:inline" method="post">
                                    <button onclick="return confirm('Xóa vĩnh viễn {{$item->name}} ?')" class="btn btn-sm btn-icon btn-secondary"><i class="far fa-trash-alt"></i></button>
                                    @csrf
                                    @method('delete')
                                </form>
                                <span class="sr-only">Edit</span></a> <a href="{{route('managedevices.restore',$item->id)}}" class="btn btn-sm btn-icon btn-secondary"><i class="fa fa-trash-restore"></i> <span class="sr-only">Remove</span></a>
                     </td>
                     @endforeach
                  </tr> 
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>
</div>
@endsection