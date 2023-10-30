@extends('layouts.master')
@section('content')
    <header class="page-title-bar">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <a href="{{ route('borrows.index') }}"><i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Trang
                        Chủ</a>
                </li>
            </ol>
        </nav>
        <!-- <button type="button" class="btn btn-success btn-floated"><span class="fa fa-plus"></span></button> -->
        <div class="d-md-flex align-items-md-start">
            <h1 class="page-title mr-sm-auto">Quản Lý Phiếu Mượn</h1>
            <div class="btn-toolbar">
                @if (Auth::user()->hasPermission('Borrow_create'))
                    <a href="{{ route('borrows.create') }}" class="btn btn-primary mr-2">
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
                        <a class="nav-link active " href="{{ route('borrows.index') }}">Tất Cả</a>

                    </li>
                    @if (Auth::user()->hasPermission('Borrow_trash'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('borrows.trash') }}">Thùng Rác</a>
                        </li>
                    @endif
                </ul>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col">
                        <form action="{{ route('borrows.index') }}" method="GET" id="form-search">

                            <div class="row">
                                <div class="col">
                                    <label>Tên</label>
                                    <select name="searchName" class="form-control select2">
                                        <option value="">Chọn giáo viên</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ request('searchName') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <label>Tổ</label>
                                    <select name="nest_id" class="form-control">
                                        <option value="">Chọn tổ</option>
                                        @foreach ($nests as $nest)
                                            <option value="{{ $nest->id }}"
                                                @selected(request('nest_id') == $nest->id)>
                                                {{ $nest->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <label>Ngày dạy từ</label>
                                    <input name="searchBorrow_date_from" value="{{ request('searchBorrow_date_from') }}"
                                        class="form-control" type="date" placeholder="Ngày dạy..." />
                                </div>

                                <div class="col">
                                    <label>Ngày dạy đến</label>
                                    <input name="searchBorrow_date_to" value="{{ request('searchBorrow_date_to') }}"
                                        class="form-control" type="date" placeholder="Ngày dạy..." />
                                </div>
                                <div class="col">
                                    <label>Năm học</label>
                                    <select name="searchSchoolYear" class="form-control">
                                        <option value="">Năm học</option>
                                        @php
                                            $currentYear = 2022;
                                            $selectedYear = request('searchSchoolYear'); // Lấy giá trị từ request
                                            
                                            for ($year = $currentYear; $year <= 2050; $year++) {
                                                $nextYear = $year + 1;
                                                $schoolYear = "$year - $nextYear";
                                            
                                                // Kiểm tra nếu giá trị của tùy chọn khớp với giá trị từ request
                                                $selected = $schoolYear == $selectedYear ? 'selected' : '';
                                            
                                                echo "<option value=\"$schoolYear\" $selected>$schoolYear</option>";
                                            }
                                        @endphp
                                    </select>
                                </div>


                                <div class="col">
                                    <label>Tình trạng trả</label>
                                    <select name="searchStatus" class="form-control">
                                        <option value="">Tình trạng...</option>
                                        <option value="1"
                                            {{ $request->input('searchStatus') === '1' ? 'selected' : '' }}>Đã
                                            trả
                                        </option>
                                        <option value="0"
                                            {{ $request->input('searchStatus') === '0' ? 'selected' : '' }}>
                                            Chưa trả
                                        </option>
                                    </select>
                                </div>

                                <div class="col">
                                    <label>Trạng thái duyệt</label>
                                    <select name="searchApproved" class="form-control">
                                        <option value="">Trạng thái...</option>
                                        <option value="0"
                                            {{ $request->input('searchApproved') === '0' ? 'selected' : '' }}>
                                            Chưa xét duyệt</option>
                                        <option value="1"
                                            {{ $request->input('searchApproved') === '1' ? 'selected' : '' }}>
                                            Đã
                                            xét duyệt</option>
                                        <option value="2"
                                            {{ $request->input('searchApproved') === '2' ? 'selected' : '' }}>
                                            Từ chối
                                        </option>
                                    </select>
                                </div>

                                <div class="col-auto" style="margin-top: 1.8rem;">
                                    <button class="btn btn-secondary" type="submit">Tìm Kiếm</button>
                                </div>
                            </div>
                        </form>

                    </div>
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
                            <th>Người dùng</th>
                            <th>Ngày tạo phiếu</th>
                            <th>Ngày dạy</th>
                            <th>Tình trạng</th>
                            <th>Xét duyệt</th>
                            <th>Chức năng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $key => $item)
                            <?php
                            $tong_muon = $item->the_devices()->count();
                            $tong_tra = $item
                                ->the_devices()
                                ->where('status', 1)
                                ->count();
                            ?>
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>
                                    @if (isset($item->user->name))
                                        <a href="{{ route('borrows.show', $item->id) }}">
                                            {{ $item->user->name }}
                                        </a>
                                    @else
                                        {{ 'không xác định' }}
                                    @endif
                                </td>

                                <td>{{ date('d/m/Y H:i:s', strtotime($item->created_at)) }}</td>
                                <td>{{ date('d/m/Y', strtotime($item->borrow_date)) }}</td>
                                <td>{{ $item->status ? 'Đã trả' : 'Chưa trả' }} ({{ $tong_tra . '/' . $tong_muon }})</td>
                                <td>
                                    @if ($item->approved == 2)
                                        Từ chối
                                    @else
                                        {{ $item->approved ? 'Đã duyệt' : 'Chưa duyệt' }}
                                    @endif
                                </td>

                                <td>
                                        <a class="btn btn-sm btn-icon btn-secondary"
                                                    href="{{  route('export_borrow',$user->id) }}">
                                                    <i class="fa-solid fa fa-plus"></i>
                                        </a>
                                    @if (Auth::user()->hasPermission('Borrow_view'))
                                        <a class="btn btn-sm btn-icon btn-secondary"
                                            href="{{ route('borrows.show', $item->id) }}">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                    @endif
                                    <span class="sr-only">Edit</span>
                                    @if (Auth::user()->hasPermission('Borrow_update'))
                                        @if ($item->approved != 1)
                                            <a href="{{ route('borrows.edit', $item->id) }}"
                                                class="btn btn-sm btn-icon btn-secondary">
                                                <i class="fa fa-pencil-alt"></i>
                                                <span class="sr-only">Remove</span>
                                            </a>
                                        @endif
                                    @endif

                                    @if (Auth::user()->hasPermission('Borrow_delete'))
                                        @if ($item->approved != 1)
                                            <form action="{{ route('borrows.destroy', $item->id) }}" style="display:inline"
                                                method="post">
                                                <button onclick="return confirm('Xóa {{ $item->name }} ?')"
                                                    class="btn btn-sm btn-icon btn-secondary">
                                                    <i class="far fa-trash-alt"></i>
                                                </button>
                                                @csrf
                                                @method('delete')
                                            </form>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div style="float:right">
                    {{ $items->appends(request()->query())->links() }}
                </div>

            </div>
        @endsection
@section('footer_scripts')

<script>
$(document).ready(function() {
    $('.select2').select2({});
});
</script>
@endsection

