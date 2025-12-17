<nav class="main-header navbar navbar-expand navbar-white navbar-light">

    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

        {{-- User menu (admin) --}}
        @if(Auth::guard('admin')->check())
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="far fa-user"></i>
                    {{ Auth::guard('admin')->user()->name }}
                    <i class="fas fa-caret-down ml-1"></i>
                </a>

                <div class="dropdown-menu dropdown-menu-right">
                    {{-- (Tuỳ chọn) Link hồ sơ --}}
                    <a class="dropdown-item" href="{{ url('/admin/profile') }}">
                        <i class="fas fa-user-circle mr-2"></i> Hồ sơ
                    </a>

                    <div class="dropdown-divider"></div>

                    {{-- ✅ Logout POST --}}
                    <a class="dropdown-item text-danger" href="#"
                       onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
                        <i class="fas fa-sign-out-alt mr-2"></i> Đăng xuất
                    </a>

                <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST" style="display:none;">
    @csrf
</form>

                </div>
            </li>
        @endif

        {{-- Fullscreen --}}
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>

    </ul>
</nav>
