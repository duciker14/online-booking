<div style="width:600px; margin: 0 auto">
    <div style="text-align: center">
        <h2>Xin chào {{ $user->name }}</h2>
        <p>Bạn đã đăng ký tại hệ thống của chúng tôi</p>
        <p>Để có thể tiếp tục sử dụng các dịch vụ vui lòng nhấn vào nút kích hoạt bên dưới để kích hoạt tài khoản</p>
        <p>
            <a href="{{ route('actived', ['token'=> $token])}}" 
                style="display:inline-block; background: blue; color:#fff; padding: 7px 25px; font-weight:bold;">
                Kích hoạt tài khoản</a>
        </p>
    </div>
</div>
