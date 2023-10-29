@extends('layouts.master')
@section('content')
    <!-- .page-title-bar -->
    <header class="page-title-bar">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <a href="{{ route('borrows.index') }}"><i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Quản Lý Phiếu
                        Mượn</a>
                </li>
            </ol>
        </nav>
        <h1 class="page-title"> Chỉnh Sửa Phiếu Mượn </h1>
    </header>

    <div class="page-section">
        <form method="post" action="{{ route('borrows.update', $item->id) }}">
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-body">
                    <legend>Thông tin cơ bản</legend>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="tf1">Người mượn </label>
                                <select class="form-control" id="user_id" name="user_id">
                                    <option value="">--Vui lòng chọn--</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            @selected($item->user_id == $user->id)>
                                            {{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('user_id'))
                                    <p style="color:red">{{ $errors->first('user_id') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="tf1">Tình trạng</label>
								@if (Auth::user()->hasPermission('Borrow_update_status'))
									<select name="status" class="form-control">
										<option value="0" {{ $item->status == '0' ? 'selected' : '' }}>Chưa trả
										</option>
										<option value="1" {{ $item->status == '1' ? 'selected' : '' }}>Đã trả</option>
									</select>
									@if ($errors->has('status'))
										<p style="color:red">{{ $errors->first('status') }}</p>
									@endif
                                @else
								<p class="form-control-static">{{ $item->status == '0' ? 'Chưa trả' : 'Đã trả' }}</p>
								<input type="hidden" name="status" value="{{ $item->status }}">
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="tf1">Xét duyệt</label>
								@if (Auth::user()->hasPermission('Borrow_update_status'))
									<select name="approved" class="form-control">
										<option value="0" {{ $item->approved == '0' ? 'selected' : '' }}>Chưa xét duyệt
										</option>
										<option value="1" {{ $item->approved == '1' ? 'selected' : '' }}> Đã xét duyệt
										</option>
										<option value="2" {{ $item->approved == '2' ? 'selected' : '' }}> Từ chối
										</option>
									</select>
									@if ($errors->has('approved'))
										<p style="color:red">{{ $errors->first('approved') }}</p>
									@endif
								@else
								<p class="form-control-static">{{ $item->approved == '0' ? 'Chưa xét duyệt' : 'Đã xét duyệt' }}</p>
								<input type="hidden" name="approved" value="{{ $item->approved }}">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="tf1">Ngày mượn</label>
                                <input type="date" name="borrow_date" value="{{ $item->borrow_date }}"
                                    class="form-control" placeholder="Nhập ngày mượn">
                                @if ($errors->has('borrow_date'))
                                    <p style="color:red">{{ $errors->first('borrow_date') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="tf1">Ngày nhập liệu</label>
                                <p class="form-control-static">{{ date('d/m/Y H:i:s', strtotime($item->created_at)) }}</p>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="tf1">Ngày cập nhật</label>
                                <p class="form-control-static">{{ date('d/m/Y H:i:s', strtotime($item->updated_at)) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tf1">Ghi chú</label>
                        <textarea name="borrow_note" class="form-control" placeholder="Nhập ghi chú">{{ $item->borrow_note }}</textarea>
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
                                            <th>Tiết PCTT</th>
                                            <th>Lớp</th>
                                            <th>Tiết TKB</th>
                                            <th>Ngày dạy</th>
                                            <!-- <th>Ngày trả</th> -->
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="device_list">
                                        @foreach ($item->the_devices as $key => $device)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td> {{ $device->device->name }}
                                                    <input name="devices[id][]" type="hidden"
                                                        value="{{ $device->device_id }}">
                                                </td>
                                                <td>
                                                    <input value="{{ $device->lesson_name }}" name="devices[lesson_name][]"
                                                        type="text" class="form-control input-sm">
                                                </td>
                                                <td width="100"> <input value="{{ $device->quantity }}"
                                                        name="devices[quantity][]" type="number"
                                                        class="form-control input-sm"> </td>
                                                <td width="120">
                                                    <select name="devices[session][]" class="form-control">
                                                        <option @selected($device->session == 'Sáng') value="Sáng">Sáng</option>
                                                        <option @selected($device->session == 'Chiều') value="Chiều">Chiều
                                                        </option>
                                                    </select>
                                                </td>
                                                <td width="100">
                                                    <input value="{{ $device->lecture_name }}"
                                                        name="devices[lecture_name][]" type="text"
                                                        class="form-control input-sm">
                                                </td>
                                                <td>
                                                    <select name="devices[room_id][]" class="form-control">
                                                        <?php foreach ($rooms as $room): ?>
                                                        <option @selected($room->id == $device->room_id) value="<?php echo $room->id; ?>">
                                                            <?php echo $room->name; ?>
                                                        </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                                <td width="100">
                                                    <select name="devices[lecture_number][]" class="form-control">
                                                        <option @selected($device->lecture_number == '1') value="1">1</option>
                                                        <option @selected($device->lecture_number == '2') value="2">2</option>
                                                        <option @selected($device->lecture_number == '3') value="3">3</option>
                                                        <option @selected($device->lecture_number == '4') value="4">4</option>
                                                        <option @selected($device->lecture_number == '5') value="5">5</option>
                                                    </select>
                                                </td>
                                                <td> <input value="{{ $device->return_date }}"
                                                        name="devices[return_date][]" type="date"
                                                        class="form-control input-sm"> </td>
                                                <td>
                                                    <button data-id="{{ $device->device_id }}" type="button"
                                                        class="btn btn-sm btn-icon btn-secondary remove-device"><i
                                                            class="far fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a class="btn btn-secondary float-right" href="{{ route('borrows.index') }}">Hủy</a>
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
            var device_ids = <?= $device_ids ?>;
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
                device_id = parseInt(device_id)

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
                device_id = parseInt(device_id)
                device_ids = device_ids.filter(item => item != device_id)
                console.log(device_ids);
                $(this).closest('tr').remove();
            });
        });
    </script>
@endsection
