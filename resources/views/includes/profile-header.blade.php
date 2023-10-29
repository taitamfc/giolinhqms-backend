@if (isset($profile))
    <div class="dropdown d-none d-md-flex">
        <button class="btn-account" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                class="user-avatar user-avatar-md"><img src="{{ $profile->image }}" alt=""></span> <span
                class="account-summary pr-lg-4 d-none d-lg-block"><span class="account-name">{{ $profile->name }}</span>
                <span class="account-description">{{ $profile->email }}</span></span></button> <!-- .dropdown-menu -->
        <div class="dropdown-menu">
            <div class="dropdown-arrow d-lg-none" x-arrow=""></div>
            <div class="dropdown-arrow ml-3 d-none d-lg-block"></div>
            <h6 class="dropdown-header d-none d-md-block d-lg-none"> {{ $profile->name }} </h6><a class="dropdown-item"
                href="{{ route('users.show',$profile->id) }}"><span class="dropdown-icon oi oi-person"></span> Trang Cá Nhân</a> <a
                class="dropdown-item" href="{{ route('logout') }}"><span
                    class="dropdown-icon oi oi-account-logout"></span> Đăng Xuất</a>
        </div>
    @else
    <div class="dropdown d-none d-md-flex">
        <button class="btn-account" type="button" onclick="window.location.href='{{route('login')}}'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
            class="user-avatar user-avatar-md"></span> <span
            class="account-summary pr-lg-4 d-none d-lg-block"><span class="account-name">Đăng Nhập</span>
            <span class="account-description"></span></span></button>
        </div>
@endif
