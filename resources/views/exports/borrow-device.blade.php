<table border="1" align="left" cellpadding="5">
    <caption></caption>
    <tr>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th align="center" width="200px"><p><strong>Quản Lý Thiết Bị Mượn :</strong></p> <br></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
</table>

<table border="1" align="left" cellpadding="5" width="100%" >
    <caption>Quản Lý Thiết Bị Mượn : </caption>
    <tr>
        <th align="center" style="font-weight: bold;" width="200px" >STT</th>
        <th align="center" style="font-weight: bold;" width="200px">Người mượn</th>
        <th align="center" style="font-weight: bold;" width="200px">Tên thiết bị</th>
        <th align="center" style="font-weight: bold;" width="80px">Tên bài dạy</th>
        <th align="center" style="font-weight: bold;">Số lượng</th>
        <th align="center" style="font-weight: bold;">Buổi</th>
        <th align="center" style="font-weight: bold;">Tiết PCCT</th>
        <th align="center" style="font-weight: bold;">Lớp</th>
        <th align="center" style="font-weight: bold;">Tiết TKB</th>
        <th align="center" style="font-weight: bold;" width="80px">Trạng thái</th>
        <th align="center" style="font-weight: bold;" width="200px">Ngày tạo phiếu</th>
        <th align="center" style="font-weight: bold;" width="200px">Ngày mượn</th>
        <th align="center" style="font-weight: bold;" width="200px">Ngày dạy</th>
    </tr>
    @foreach ($BorrowDevices as $key => $item)
        <tr>
            <td align="center">{{ ++$key }}</td>
            <td align="center">{{ $item->borrow->user->name ?? '(Không tồn tại)' }}</td>
            <td align="center">{{ $item->device && $item->device->name ? $item->device->name : '(Không tồn tại)' }}</td>
            <td align="center">{{ $item->lesson_name }}</td>
            <td align="center">{{ $item->quantity }}</td>
            <td align="center">{{ $item->session }}</td>
            <td align="center">{{ $item->lecture_name }}</td>
            <td align="center">{{ $item->room && $item->room->name ? $item->room->name : '(Không tồn tại)' }}</td>
            <td align="center">{{ $item->lecture_number }}</td>
            <td align="center">{{ $changeStatus[$item->status] }}</td>
            <td align="center">{{ $item->borrow?->created_at ? $item->borrow->created_at->format('d/m/Y H:i:s') : '' }}</td>
            <td align="center">{{ $item->borrow && $item->borrow->borrow_date ?  date('d/m/Y', strtotime($item->borrow->borrow_date)) : '(Không tồn tại)' }}</td>
            <td align="center">{{ $item->return_date ? date('d/m/Y', strtotime($item->return_date)) : '(Không tồn tại)'}}</td>
        </tr>
    @endforeach
</table>