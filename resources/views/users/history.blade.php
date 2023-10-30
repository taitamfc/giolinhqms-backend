@extends('layouts.master')
@section('content')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const collapseButtons = document.querySelectorAll('.collapse-button');
            collapseButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = button.getAttribute('data-target');
                    const targetRow = document.querySelector(targetId);

                    if (targetRow) {
                        targetRow.classList.toggle('show');
                    }
                });
            });
        });
    </script>

    <header class="page-title-bar">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <a href="#"><i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Trang Chủ</a>
                </li>
            </ol>
        </nav>
        <div class="d-md-flex align-items-md-start">
            <h1 class="page-title mr-sm-auto">Xem lịch sử mượn thiết bị của giáo viên : {{ $user->name }}</h1>
            <div class="btn-toolbar">
                    <a href="{{ route('exportBook',$user->id) }}" class="btn btn-primary mr-2">
                        <i class="fa-solid fa fa-plus"></i>
                        <span class="ml-1">Xuất Sổ PDF</span>
                    </a>
                    <a href="{{ route('export_history_book',$user->id) }}" class="btn btn-primary mr-2">
                        <i class="fa-solid fa fa-plus"></i>
                        <span class="ml-1">Xuất Sổ Excel</span>
                    </a>
            </div>
        </div>
    </header>
    <div class="page-section">
        <div class="row">
            <div class="col-lg-4">
                <div class="card card-fluid">
                    <h6 class="card-header"> Chi tiết </h6>
                    <nav class="nav nav-tabs flex-column border-0">
                        <a href="{{ route('users.show', $user->id) }}" class="nav-link">Chi tiết giáo
                            viên</a>
                        <a href="{{ route('users.borrow_history', $user->id) }}" class="nav-link active">Lịch
                            sử mượn</a>
                    </nav>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card card-fluid">
                    <h6 class="card-header"> Lịch sử mượn thiết bị </h6>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Ngày dạy</th>
                                <th>Số lượng</th>
                                <th>Tình trạng duyệt</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($history as $index => $item)
                                @if (isset($item->borrow_date))
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ date('d/m/Y', strtotime($item->borrow_date)) }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $changeApproved[$item->approved] }}</td>
                                        <td class="align-middle px-0" style="width: 1.5rem">
                                            <button type="button" class="btn btn-sm btn-icon btn-light"
                                                data-toggle="collapse"
                                                data-target="#details-cid{{ $item->borrow_device_id }}">
                                                <span class="collapse-indicator"><i
                                                        class="fa fa-angle-right"></i></span></button>
                                        </td>
                                    </tr>
                                @endif
                                <tr class="row-details bg-light collapse" id="details-cid{{ $item->borrow_device_id }}">
                                    <td colspan="6">
                                        <div class="row">
                                            <h6 class="card-header"> Chi tiết mượn thiết bị </h6>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>STT</th>
                                                        <th>Ngày dạy</th>
                                                        <th>Tên thiết bị</th>
                                                        <th>Lớp học</th>
                                                        <th>Trạng thái</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($history as $index => $subItem)
                                                        @if ($subItem->borrow_id === $item->borrow_id)
                                                            @php
                                                                $borrowExists = App\Models\Borrow::find($subItem->borrow_id);
                                                            @endphp
                                                            <tr>
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>{{ date('d/m/Y', strtotime($subItem->return_date)) }}</td>
                                                                <td>{{ $subItem->device_name }}</td>
                                                                <td>{{ $subItem->room_name }}</td>
                                                                <td>{{ $changeStatus[$subItem->status] }}</td>
                                                                @if ($borrowExists)
                                                                    <td>
                                                                        <span class="sr-only">Edit</span></a> <a
                                                                            href="{{ route('borrows.show', $subItem->borrow_id) }}"
                                                                            class="btn btn-sm btn-icon btn-secondary"> <i class="fa-solid fa-eye"></i>
                                                                            <span class="sr-only">Remove</span></a>
                                                                    </td>
                                                                @endif
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div style="float:right">
                    {{ $history->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
