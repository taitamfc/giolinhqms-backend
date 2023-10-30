@extends('layouts.master')
@section('content')
<header class="page-title-bar">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">
                <a href="{{route('borrows.index')}}"><i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Quản Lý Thiết
                    Bị </a>
            </li>
        </ol>
    </nav>
    <h1 class="page-title">Thêm Phiếu Mượn</h1>
</header>
<div class="page-section">
    <form method="post" action="{{route('borrows.store')}}" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-body">
                <legend>Thông tin cơ bản</legend>

                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="exampleSelectGender">Người mượn<abbr name="Trường bắt buộc">*</abbr></label>
                            <select class="form-control" id="user_id" name="user_id">
                                <option value="">--Vui lòng chọn--</option>
                                @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->any())
                            <p style="color:red">{{ $errors->first('user_id') }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="tf1">Ngày tạo phiếu<abbr name="Trường bắt buộc">*</abbr></label>
                            <input name="created_at" type="text" class="form-control" id="" placeholder="Nhập ngày"
                                value="{{ old('created_at', date('Y-m-d H:i:s')) }}">
                            <small id="" class="form-text text-muted"></small>
                            @if ($errors->any())
                            <p style="color:red">{{ $errors->first('created_at') }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-4">

                        <div class="form-group">
                            <label for="tf1">Ngày dạy<abbr name="Trường bắt buộc">*</abbr></label> <input
                                name="borrow_date" type="date" class="form-control" id="" placeholder="Nhập ngày dạy"
                                value="{{ old('borrow_date') }}">
                            <small id="" class="form-text text-muted"></small>
                            @if ($errors->any())
                            <p style="color:red">{{ $errors->first('borrow_date') }}</p>
                            @endif
                        </div>
                    </div>
                </div>



                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="tf1">Tình trạng<abbr name="Trường bắt buộc">*</abbr></label>
                            <select name="status" class="form-control">
                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Chưa trả
                                </option>
                                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Đã trả</option>
                            </select>
                            <small id="" class="form-text text-muted"></small>
                            @if ($errors->any())
                            <p style="color:red">{{ $errors->first('status') }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="tf1">Xét duyệt<abbr name="Trường bắt buộc">*</abbr></label>
                            <select name="approved" class="form-control">
                                <option value="0" {{ old('approved') == '0' ? 'selected' : '' }}>Chưa
                                    xét duyệt</option>
                                <option value="1" {{ old('approved') == '1' ? 'selected' : '' }}>
                                    Đã xét
                                    duyệt</option>
                                <option value="2" {{ old('approved') == '2' ? 'selected' : '' }}>Từ chối
                                </option>
                            </select>
                            <small id="" class="form-text text-muted"></small>
                            @if ($errors->any())
                            <p style="color:red">{{ $errors->first('approved') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="tf1">Ghi chú</label>
                    <textarea name="borrow_note" class="form-control" id="" rows="3"
                        placeholder="Nhập ghi chú">{{ old('borrow_note') }}</textarea>
                    <small id="" class="form-text text-muted"></small>
                    @if ($errors->has('borrow_note'))
                    <p style="color:red">{{ $errors->first('borrow_note') }}</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <legend>Chi tiết phiếu mượn</legend>

                <div class="row">
                    <div class="col">
                        <select id="devices" class="form-control" name="state"></select>
                    </div>
                    <div class="col-lg-2">
                        <button id="addToDanhSach" class="btn btn-primary" type="button">Thêm vào danh sách</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        @if ($errors->any())
                        <p style="color:red">{{ $errors->first('devices') }}</p>
                        @endif
                    </div>
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tên</th>
                                        <th>Tên bài dạy</th>
                                        <th>Số lượng</th>
                                        <th>Buổi</th>
                                        <th>Tiết PCCT</th>
                                        <th>Lớp</th>
                                        <th>Tiết TKB</th>
                                        <th>Ngày trả</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="device_list">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a class="btn btn-secondary float-right" href="{{route('borrows.index')}}">Hủy</a>
                    <button class="btn btn-primary ml-auto" type="submit">Lưu</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@section('footer_scripts')

<script>
$(document).ready(function() {
    var device_ids = [];
    $('#user_id').select2({});
    $('#devices').select2({
        ajax: {
            url: "{{ route('borrows.devices') }}",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    searchName: params.term, // Change "term" to "searchName"
                    page: params.page
                };
            },
            processResults: function(data) {
                return {
                    results: data
                };
            },
            cache: true
        },
        placeholder: 'Chọn một tùy chọn',
        minimumInputLength: 1
    });

    function remove_device() {
        alert(1)
    }
    var device_template = `
        <tr>
            <td>DEVICE_STT</td>
            <td>DEVICE_NAME <input name="devices[id][]" type="hidden" value="DEVICE_ID"></td>
            <td> <input name="devices[lesson_name][]" type="text" class="form-control input-sm"> </td>
            <td width="100"> <input name="devices[quantity][]" type="number" class="form-control input-sm"> </td>
            <td width="120">
                <select name="devices[session][]" class="form-control">
                    <option value="Sáng">Sáng</option>
                    <option value="Chiều">Chiều</option>
                </select>
            </td>
            <td width="100"> <input name="devices[lecture_name][]" type="text" class="form-control input-sm"> </td>
            <td>
                <select name="devices[room_id][]" class="form-control">
                    <?php foreach ($rooms as $room): ?>
                        <option value="<?php echo $room->id; ?>"><?php echo $room->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
            <td width="100">
                <select name="devices[lecture_number][]" class="form-control">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </td>
            <td> <input name="devices[return_date][]" type="date" class="form-control input-sm"> </td>
            <td>
                <button data-id="DEVICE_ID" type="button" class="btn btn-sm btn-icon btn-secondary remove-device"><i
                        class="far fa-trash"></i></button>
            </td>
        </tr>
    `;

    $('#addToDanhSach').on('click', function() {
        var device_id = $('#devices').val();
        if (device_id) {
            if (device_ids.indexOf(device_id) >= 0) {
                alert('Thiết bị này đã có trong danh sách');
                return false;
            }

            var device_name = $('#devices option:selected').text();
            var device_item = device_template;
            device_item = device_item.replace('DEVICE_STT', device_id);
            device_item = device_item.replaceAll('DEVICE_ID', device_id);
            device_item = device_item.replace('DEVICE_NAME', device_name);

            $('#device_list').append(device_item);

            device_ids.push(device_id);

            $('#devices').val('').trigger('change');
        } else {
            alert('Vui lòng lựa chọn thiết bị');
        }
    });

    $('body').on('click', '.remove-device', function() {
        let device_id = $(this).data('id');
        device_ids = device_ids.filter(item => item !== device_id)
        $(this).closest('tr').remove();
    });
});
</script>
@endsection