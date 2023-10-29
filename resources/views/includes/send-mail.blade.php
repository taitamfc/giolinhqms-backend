<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
<div>
    <h3>Xin chào, {{ $data['name'] }}</h3>
    <p>Bạn vừa yêu cầu đặt lại mật khẩu.</p>
    <b>Email của bạn: {{ $data['email'] }}<br></b>
    <b>Mật khẩu mới của bạn là: {{ $data['pass'] }}</b>
    <p><br>Nếu có vấn đề gì thắc mắc <br> Vui lòng liên hệ quản trị viên!</p>
</div>