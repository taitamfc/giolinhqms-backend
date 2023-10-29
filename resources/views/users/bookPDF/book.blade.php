<!DOCTYPE html>
<html>

<head>
    <title>Sổ Mượn</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style type="text/css">
        * {
            font-family: DejaVu Sans, sans-serif;
        }

        body {
            font-size: 13px;
            height: 100vh;
            margin: 0;
            padding: 0;
        }

        table {
            border-collapse: collapse;
            margin: 0;
            padding: 0;
        }

        td {
            vertical-align: middle;
        }

        caption {
            font-size: 15px;
            font-weight: bold;
            text-align: left;
            color: rgb(0, 102, 255);
        }

        .companyInfo {
            font-size: 13px;
            font-weight: bold;
            text-align: left;
        }

        .thongtin {
            font-size: 20px;
            font-weight: bold;
            text-align: left;
        }

        .companyImg {
            width: 200px;
            height: 200px;
        }

        .page {
            page-break-after: always;
        }

        .page-content {
            margin: 20px;
        }

        @media print {
            .page {
                page-break-after: always;
            }
        }

        tr {
            height: 10%;
        }
    </style>
</head>

<body>
    <div class="page">
        <div class="page-content">
            <table border="0" align="left" width="100%" style="padding: 0; margin: 0;">
                <tr>
                    <td class="companyInfo" align="left" width="50%" style="padding: 0; margin: 0;">
                        <p style="font-size: 50px;">&#9733;</p>
                    </td>
                    <td class="companyInfo" align="left" width="50%" style="padding: 0; margin: 0;">Date:
                        <?php echo date('Y-m-d'); ?></td>
                    <td style="padding: 0; margin: 0;"></td>
                </tr>
            </table>

            <table border="0" align="left" width="100%">
                <tr>
                    <td class="companyInfo" align="left" width="50%">
                        http://thptgiolinh.com/<br />
                        (0533).825.433<br />
                    </td>
                    <td class="companyInfo" align="left" width="50%">
                        Trường THPT Gio Linh<br />
                        Địa chỉ : Thị Trấn Gio Linh - Huyện Gio Linh - Tỉnh Quảng Trị
                    </td>
                </tr>
            </table>
            <br>
            <br>
            <br>
            <table border="0" align="left" width="100%">
                <caption align="left">Thông tin người mượn :</caption><br>
                <tr>
                    <td align="left" width="50%">
                        Tên giáo viên : <br>
                        E-mail : <br>
                        Số điện thoại : <br>
                    </td>
                    <td align="left" width="50%">
                        {{ $user->name }}<br />
                        {{ $user->email }}<br />
                        {{ $user->phone }}<br />
                    </td>
                </tr>
            </table>
            <br>
            <br>
            <br>
        </div>
    </div>
    <div class="page">
        <div class="page-content">
            <table border="1" align="left" cellpadding="5" width="100%"  height="100%">
                <caption>Sổ phiếu mượn thiết bị của giáo viên: {{ $user->name }}</caption>
                <thead class="thead-dark">
                    <tr height="9%">
                        <th scope="col">STT</th>
                        <th scope="col">Người mượn</th>
                        <th scope="col">Tên thiết bị</th>
                        <th scope="col">Tên bài dạy</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Buổi</th>
                        <th scope="col">Tiết PCCT</th>
                        <th scope="col">Lớp</th>
                        <th scope="col">Tiết TKB</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Ngày mượn</th>
                        <th scope="col">Ngày dạy</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($borrowDevices as $key => $borrowDevice)
                        <tr height="9%">
                            <td align="center">{{ $number += 1 }}</td>
                            <td align="center">{{ $user->name }}</td>
                            <td align="center">{{ $borrowDevice->device->name }}</td>
                            <td align="center">{{ $borrowDevice->lesson_name }}</td>
                            <td align="center">{{ $borrowDevice->quantity }}</td>
                            <td align="center">{{ $borrowDevice->session }}</td>
                            <td align="center">{{ $borrowDevice->lecture_name }}</td>
                            <td align="center">{{ $borrowDevice->room->name }}</td>
                            <td align="center">{{ $borrowDevice->lecture_number }}</td>
                            <td align="center">{{ $changeStatus[$borrowDevice->status] }}</td>
                            <td align="center">{{ $borrowDevice->borrow_date }}</td>
                            <td align="center">{{ $borrowDevice->return_date }}</td>
                        </tr>
                        @if (($key + 1) % 10 == 0 && $key + 1 != count($borrowDevices))
                </tbody>
            </table>
        </div>
    </div>

    <div class="page">
        <div class="page-content">
            <table border="1" align="left" cellpadding="5" width="100%" height="100%">
                <caption>Sổ phiếu mượn thiết bị của giáo viên: {{ $user->name }}</caption>
                <thead class="thead-dark">
                    <tr height="9%">
                        <th scope="col">STT</th>
                        <th scope="col">Người mượn</th>
                        <th scope="col">Tên thiết bị</th>
                        <th scope="col">Tên bài dạy</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Buổi</th>
                        <th scope="col">Tiết PCCT</th>
                        <th scope="col">Lớp</th>
                        <th scope="col">Tiết TKB</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Ngày mượn</th>
                        <th scope="col">Ngày dạy</th>
                    </tr>
                </thead>
                <tbody>
                    @endif
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
    <table border="0" align="left">
        <tr>
            <td>
                <h4>Ghi chú:</h4>
            </td>
            @foreach ($borrowDevices as $key => $borrowDevice)
                <td>{{ $borrowDevice->borrow->borrow_note }}</td>
            @endforeach
        </tr>
    </table>
</body>

</html>
