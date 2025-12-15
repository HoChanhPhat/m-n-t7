<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow">  
    <div class="container">

        <!-- Logo -->
        <a class="navbar-brand fw-bold" href="{{ url('/') }}">TechStore</a>

        <!-- Toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <!-- Menu trái -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Trang chủ</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('products.all') }}">Sản phẩm</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/seller/center') }}">Người bán</a></li>
            </ul>

            <!-- 🔍 Tìm kiếm -->
            <form action="{{ route('products.search') }}" method="GET" class="d-flex me-3" style="max-width: 320px; width: 100%;">
                <div class="input-group">
                    <input type="text" name="q" class="form-control form-control-sm"
                        placeholder="Tìm kiếm sản phẩm..." value="{{ request('q') }}">
                    <button class="btn btn-outline-light" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>

            <!-- ❤️ Wishlist -->
            <li class="nav-item me-3">
                <a href="{{ route('wishlist.index') }}" class="nav-link">
                    <i class="fa fa-heart fs-5 text-danger"></i>
                </a>
            </li>

            <ul class="navbar-nav align-items-center">

                <!-- 🔔 Thông báo -->
                <li class="nav-item me-3">
                    <a href="{{ url('/notifications') }}" class="nav-link position-relative">
                        <i class="bi bi-bell fs-5"></i>
                    </a>
                </li>

                <!-- 🛒 Giỏ hàng -->
                <li class="nav-item me-3">
                    <a href="{{ url('/cart') }}" class="nav-link position-relative">
                        <i class="bi bi-cart3 fs-5"></i>

                        <span id="cart-badge"
                              class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                              style="font-size: 0.75rem;">
                            {{ $cart_count ?? 0 }}
                        </span>
                    </a>
                </li>

                <!-- 👤 User -->
                @auth
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end shadow">
                        <li><a class="dropdown-item" href="{{ url('/account') }}">Thông tin cá nhân</a></li>
                        <li><a class="dropdown-item" href="{{ url('/orders') }}">Lịch sử đơn hàng</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="dropdown-item text-danger">Đăng xuất</button>
                            </form>
                        </li>
                    </ul>
                </li>
                @endauth

                @guest
                <li class="nav-item">
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">
                        <i class="bi bi-person"></i> Đăng nhập
                    </a>
                </li>
                @endguest

            </ul>

        </div>
    </div>
</nav>
