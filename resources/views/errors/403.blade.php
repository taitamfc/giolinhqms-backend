@extends('errors::minimal')

@section('title', __('Not Found'))
@section('code')
<div class="empty-state-container">
    <div class="state-figure">
        <img class="img-fluid" src="assets/images/illustration/img-2.svg" alt="" style="max-width: 320px">
    </div>
    <h3 class="state-header"> Xin Lỗi ! </h3>
    <div class="state-action">
        <a href="javascript:history.back()" class="btn btn-lg btn-light"><i class="fa fa-angle-right"></i> Trở về</a>
    </div>
</div>
@endsection
@section('message')
<p class="state-description lead text-muted"> Bạn Không có quyền truy cập trang này! </p>
@endsection