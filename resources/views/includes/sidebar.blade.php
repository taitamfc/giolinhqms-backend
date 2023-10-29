<aside class="app-aside app-aside-expand-md app-aside-light">
    <!-- .aside-content -->
    <div class="aside-content">
        <!-- .aside-header -->
        <header class="aside-header d-block d-md-none">
            <!-- .btn-account -->
            <button class="btn-account" type="button" data-toggle="collapse" data-target="#dropdown-aside"><span
                    class="user-avatar user-avatar-lg"><img src="assets/images/avatars/profile.jpg" alt=""></span>
                <span class="account-icon"><span class="fa fa-caret-down fa-lg"></span></span> <span
                    class="account-summary"><span class="account-name">Beni Arisandi</span> <span
                        class="account-description">Marketing Manager</span></span></button>
            <!-- /.btn-account -->
            <!-- .dropdown-aside -->
            <div id="dropdown-aside" class="dropdown-aside collapse">
                <!-- dropdown-items -->
                <div class="pb-3">
                    <a class="dropdown-item" href="user-profile.html"><span class="dropdown-icon oi oi-person"></span>
                        Profile</a> <a class="dropdown-item" href="auth-signin-v1.html"><span
                            class="dropdown-icon oi oi-account-logout"></span>
                        Logout</a>
                    <div class="dropdown-divider"></div><a class="dropdown-item" href="#">Help
                        Center</a> <a class="dropdown-item" href="#">Ask Forum</a> <a class="dropdown-item"
                        href="#">Keyboard Shortcuts</a>
                </div><!-- /dropdown-items -->
            </div><!-- /.dropdown-aside -->
        </header><!-- /.aside-header -->
        <!-- .aside-menu -->
        <div class="aside-menu overflow-hidden">
            <!-- .stacked-menu -->
            <nav id="stacked-menu" class="stacked-menu">
                <!-- .menu -->
                <ul class="menu">
                    <!-- .menu-item -->
                    <li class="menu-item">
                        <a href="{{ route('users.index') }}" class="menu-link"><span
                                class="menu-icon fas fa-home"></span>
                            <span class="menu-text">Trang chủ</span></a>
                    </li><!-- /.menu-item -->
                    <!-- .menu-item -->
                    <!-- .menu-header -->
                    <li class="menu-header">Danh Mục </li><!-- /.menu-header -->
                    <!-- .menu-item -->
                    <!-- .menu-item -->
                    @if (Auth::user()->hasPermission('User_viewAny'))
                        <li class="menu-item has-child">
                            <a href="#" class="menu-link"><span class="menu-icon"><i
                                        class="fas fa-users"></i></span>
                                <span class="menu-text">Giáo Viên</span></a> <!-- child menu -->
                            <ul class="menu">
                                <li class="menu-item">
                                    <a href="{{ route('users.index') }}" class="menu-link">Danh Sách</a>
                                </li>
                            </ul><!-- /child menu -->
                        </li><!-- /.menu-item -->
                    @endif
                    <li class="menu-item has-child">
                        <a href="#" class="menu-link"><span class="menu-icon"><i class="fa-solid fa-restroom"></i></span>
                            <span class="menu-text">Tổ</span></a> <!-- child menu -->
                        <ul class="menu">
                            <li class="menu-item">
                                <a href="{{ route('nests.index') }}" class="menu-link">Danh Sách</a>
                            </li>
                        </ul><!-- /child menu -->
                    </li><!-- /.menu-item -->
                    <!-- .menu-item -->
                    @if (Auth::user()->hasPermission('Device_viewAny'))
                        <li class="menu-item has-child">
                            <a href="#" class="menu-link"><span class="menu-icon oi oi-browser"></span> <span
                                    class="menu-text">Thiết Bị</span> </a>
                            <!-- child menu -->
                            <ul class="menu">
                                <li class="menu-item">
                                    <a href="{{ route('devices.index') }}" class="menu-link">Danh Sách</a>
                                </li>
                            </ul><!-- /child menu -->
                        </li><!-- /.menu-item -->
                    @endif
                        <li class="menu-item has-child">
                            <a href="#" class="menu-link"><span class="menu-icon oi oi-browser"></span> <span
                                    class="menu-text">Bộ Môn</span> </a>
                            <!-- child menu -->
                            <ul class="menu">
                                <li class="menu-item">
                                    <a href="{{ route('departments.index') }}" class="menu-link">Danh Sách</a>
                                </li>
                            </ul><!-- /child menu -->
                        </li><!-- /.menu-item -->
                    <li class="menu-item has-child">
                        <a href="#" class="menu-link"> <span class="menu-icon"><i class="fas fa-balance-scale"></i></span>
                            <span class="menu-text">Loại Thiết Bị</span></a> <!-- child menu -->
                        <ul class="menu">
                            <li class="menu-item">
                                <a href="{{ route('devicetypes.index') }}" class="menu-link">Danh Sách Loại</a>
                            </li>
                        </ul><!-- /child menu -->
                    </li>
                    <!-- .menu-item -->
                    @if (Auth::user()->hasPermission('Room_viewAny'))
                        <li class="menu-item has-child">
                            <a href="#" class="menu-link"><span class="menu-icon oi oi-aperture"></span> <span
                                    class="menu-text">Lớp Học</span> </a>
                            <!-- child menu -->
                            <ul class="menu">
                                <li class="menu-item">
                                    <a href="{{ route('rooms.index') }}" class="menu-link">Danh Sách</a>
                                </li>
                            </ul><!-- /child menu -->
                        </li><!-- /.menu-item -->
                    @endif
                    <li class="menu-item has-child">
                        <a href="#" class="menu-link"> <span class="menu-icon"><i class="fas fa-book"></i></span>
                            <span class="menu-text">Phiếu Mượn</span></a> <!-- child menu -->
                        <ul class="menu">
                            <li class="menu-item">
                                <a href="{{ route('borrows.index') }}" class="menu-link">Danh Sách Phiếu</a>
                            </li>
                        </ul><!-- /child menu -->
                    </li>
                    <li class="menu-item has-child">
                        <a href="#" class="menu-link"> <span class="menu-icon"><i class="fas fa-book"></i></span>
                            <span class="menu-text">Quản Lý Thiết Bị Mượn</span></a> <!-- child menu -->
                        <ul class="menu">
                            <li class="menu-item">
                                <a href="{{ route('borrowdevices.index') }}" class="menu-link">Danh Sách</a>
                            </li>
                        </ul><!-- /child menu -->
                    </li>
                    @if (Auth::user()->hasPermission('Group_viewAny'))
                        <li class="menu-item has-child">
                            <a href="#" class="menu-link"><span class="menu-icon oi oi-person"></span>
                                <span class="menu-text">Quyền Quản Trị</span></a> <!-- child menu -->
                            <ul class="menu">
                                <li class="menu-item">
                                    <a href="{{ route('groups.index') }}" class="menu-link">Danh Sách Quyền</a>
                                </li>
                            </ul><!-- /child menu -->
                        </li><!-- /.menu-item -->
                    @endif
                    @if (Auth::user()->hasPermission('Option_update'))
                    <li class="menu-item">
                        <a href="{{ route('options.index') }}" class="menu-link"><span
                                class="menu-icon fas fa-gear"></span>
                            <span class="menu-text">Cấu Hình</span></a>
                    </li>
                    @endif
                </ul><!-- /.menu -->
            </nav><!-- /.stacked-menu -->
        </div><!-- /.aside-menu -->
        <!-- Skin changer -->
        <footer class="aside-footer border-top p-2">

        </footer><!-- /Skin changer -->
    </div><!-- /.aside-content -->
</aside>
