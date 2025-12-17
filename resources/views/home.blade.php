@extends('layouts.app')
@section('title', 'Trang chủ')

@section('content')

<!-- Carousel banner -->
<div id="bannerCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active" onclick="openNewUserPopup()" style="cursor:pointer;">
    <img src="{{ asset('images/hehe.jpg') }}" class="d-block w-100 banner-img" alt="Banner 1">

    </div>

    <div class="carousel-item">
     <a href="#"><img src="{{ asset('images/e.jpg') }}" class="d-block w-100 banner-img" alt="Banner 2"></a>
    </div>
    <div class="carousel-item">
     <a href="#"><img src="{{ asset('images/q.jpg') }}" class="d-block w-100 banner-img" alt="Banner 3"></a>
    </div>
  </div>

  <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>

  <div class="carousel-indicators">
    <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="0" class="active"></button>
    <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="1"></button>
    <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="2"></button>
  </div>
</div>

<!-- Sản phẩm nổi bật -->
<section class="container my-5">
  <h2 class="text-center mb-4 fw-bold">🔥 Sản phẩm nổi bật</h2>
  <div class="row g-4">
    @foreach($featured as $product)
      <div class="col-md-3 mb-4">
          <x-product-card :product="$product" :wishlist="$wishlist" />
      </div>
    @endforeach
  </div>
</section>

<!-- Sản phẩm mới nhất -->
<section class="container my-5">
  <h2 class="text-center mb-4 fw-bold">🆕 Sản phẩm mới nhất</h2>
  <div class="text-center mb-4">
    <a href="{{ route('web.products.all') }}" class="btn btn-primary">Xem tất cả sản phẩm</a>
  </div>

  <div class="row g-4">
    @foreach($latest as $product)
      <div class="col-md-3 mb-4">
          <x-product-card :product="$product" :wishlist="$wishlist" />
      </div>
    @endforeach
  </div>
</section>

<!-- Danh mục sản phẩm -->
<div class="container mt-5">
  <h4 class="text-center mb-4 fw-bold">Danh mục nổi bật</h4>
  <div class="row">
    <div class="col-md-4 mb-3">
      <a href="{{ route('category.show', 1) }}" class="text-decoration-none text-dark">
        <div class="card h-100 shadow-sm hover-shadow">
          <img src="{{ asset('images/o.jpg') }}" class="card-img-top" alt="Laptop">
          <div class="card-body text-center">
            <h5 class="card-title fw-bold">Laptop</h5>
            <p class="card-text">Thiết bị đáng tin cậy cho công việc và học tập.</p>
          </div>
        </div>
      </a>
    </div>

    <div class="col-md-4 mb-3">
      <a href="{{ route('category.show', 2) }}" class="text-decoration-none text-dark">
        <div class="card h-100 shadow-sm hover-shadow">
          <img src="{{ asset('images/u.jpg') }}" class="card-img-top" alt="Điện thoại">
          <div class="card-body text-center">
            <h5 class="card-title fw-bold">Điện thoại</h5>
            <p class="card-text">Mua bán điện thoại chất lượng cao.</p>
          </div>
        </div>
      </a>
    </div>

    <div class="col-md-4 mb-3">
      <a href="{{ route('category.show', 3) }}" class="text-decoration-none text-dark">
        <div class="card h-100 shadow-sm hover-shadow">
          <img src="{{ asset('images/i.jpg') }}" class="card-img-top" alt="Phụ kiện">
          <div class="card-body text-center">
            <h5 class="card-title fw-bold">Phụ kiện</h5>
            <p class="card-text">Phụ kiện chính hãng, giá rẻ, đa dạng mẫu mã.</p>
          </div>
        </div>
      </a>
    </div>
  </div>
</div>

<style>
.hover-shadow:hover {
  transform: translateY(-4px);
  transition: 0.2s;
  box-shadow: 0 6px 15px rgba(0,0,0,0.1);
}
.btn-success i {
  font-size: 16px;
}
.brand-scroll {
  display: flex;
  gap: 18px;
  overflow-x: auto;
  padding: 12px 6px;
  scrollbar-width: none;
}
.brand-scroll::-webkit-scrollbar { display: none; }
.brand-logo { height: 40px; opacity: 0.9; transition: 0.2s; }
.brand-logo:hover { opacity: 1; transform: translateY(-2px); }


/* ===== FIX BANNER (KHÔNG CẮT ẢNH) ===== */
#bannerCarousel {
  border-radius: 14px;
  overflow: hidden;
}

/* Tự co theo chiều ngang màn hình, không cần height cứng */
#bannerCarousel .carousel-item {
  aspect-ratio: 16 / 6;   /* bạn có thể đổi: 16/7, 16/5 tùy banner */
  background: #0b1b2a;    /* màu nền cho phần trống (nếu có) */
}

/* Hiện full ảnh, không crop */
#bannerCarousel .banner-img{
  width: 100%;
  height: 100%;
  object-fit: contain;
}

</style>

<!-- Thương hiệu nổi bật -->
<div class="container my-5">
  <h4 class="text-center mb-4 fw-bold">Thương hiệu nổi bật</h4>

  <div class="brand-scroll">
    <a href="#"><img src="{{ asset('images/brands/apple.png') }}" alt="Apple" class="brand-logo"></a>
    <a href="#"><img src="{{ asset('images/brands/samsung.png') }}" alt="Samsung" class="brand-logo"></a>
    <a href="#"><img src="{{ asset('images/brands/asus.png') }}" alt="Asus" class="brand-logo"></a>
    <a href="#"><img src="{{ asset('images/brands/dell.png') }}" alt="Dell" class="brand-logo"></a>
    <a href="#"><img src="{{ asset('images/brands/hp.png') }}" alt="HP" class="brand-logo"></a>
    <a href="#"><img src="{{ asset('images/brands/lenovo.png') }}" alt="Lenovo" class="brand-logo"></a>
    <a href="#"><img src="{{ asset('images/brands/xiaomi.png') }}" alt="Xiaomi" class="brand-logo"></a>
    <a href="#"><img src="{{ asset('images/brands/realme.png') }}" alt="Realme" class="brand-logo"></a>
  </div>
</div>

<script>
const slider = document.querySelector('.brand-scroll');
let isDown = false;
let startX;
let scrollLeft;

if (slider) {
  slider.addEventListener('mousedown', (e) => {
    isDown = true;
    startX = e.pageX - slider.offsetLeft;
    scrollLeft = slider.scrollLeft;
  });
  slider.addEventListener('mouseleave', () => isDown = false);
  slider.addEventListener('mouseup', () => isDown = false);
  slider.addEventListener('mousemove', (e) => {
    if (!isDown) return;
    e.preventDefault();
    const x = e.pageX - slider.offsetLeft;
    const walk = (x - startX) * 1.2;
    slider.scrollLeft = scrollLeft - walk;
  });

  setInterval(() => {
    if (slider.scrollLeft + slider.clientWidth >= slider.scrollWidth - 5) {
      slider.scrollTo({ left: 0, behavior: 'smooth' });
    } else {
      slider.scrollBy({ left: 2, behavior: 'smooth' });
    }
  }, 50);
}
</script>

<!-- ========================= -->
<!-- Popup voucher người mới   -->
<!-- ========================= -->
<div class="modal fade" id="newUserVoucherModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-3">

      <div class="d-flex align-items-center justify-content-between mb-2">
        <h4 class="mb-0 fw-bold">🎉 Voucher dành cho người mới</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div id="voucher-list">
        <!-- JS sẽ đổ voucher vào đây -->
      </div>

    </div>
  </div>
</div>

<!-- ========================= -->
<!-- Modal thông báo (đẹp)     -->
<!-- ========================= -->
<div class="modal fade" id="notifyModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="notifyTitle">Thông báo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body" id="notifyBody">...</div>

      <div class="modal-footer" id="notifyFooter">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
      </div>

    </div>
  </div>
</div>

<script>
let voucherModalInstance = null;
let notifyModalInstance = null;

function getCsrfToken() {
  const el = document.querySelector('meta[name="csrf-token"]');
  return el ? el.content : '';
}

function showNotify(title, bodyHtml, footerHtml = '') {
  document.getElementById('notifyTitle').innerText = title;
  document.getElementById('notifyBody').innerHTML = bodyHtml;

  document.getElementById('notifyFooter').innerHTML = footerHtml || `
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
  `;

  if (!notifyModalInstance) {
    notifyModalInstance = new bootstrap.Modal(document.getElementById('notifyModal'));
  }
  notifyModalInstance.show();
}

function openNewUserPopup() {
  fetch('/event/new-user/vouchers', {
    headers: { 'Accept': 'application/json' }
  })
    .then(async (res) => {
      // nếu backend trả lỗi/HTML
      const text = await res.text();
      try { return JSON.parse(text); }
      catch { throw new Error('Server không trả JSON. Kiểm tra route /event/new-user/vouchers'); }
    })
    .then((data) => {
      let html = '';

      if (!Array.isArray(data) || data.length === 0) {
        html = '<p class="mb-0">Không có voucher nào dành cho người mới.</p>';
      } else {
        data.forEach(v => {
          html += `
            <div class="border rounded p-2 mb-2">
              <div class="fw-bold">${v.code}</div>
              <div class="text-muted small mb-2">${v.description ?? ''}</div>

              <button
                class="btn btn-primary btn-sm"
                id="btn-save-${v.id}"
                onclick="saveVoucher(${v.id})"
              >
                Lưu voucher
              </button>
            </div>
          `;
        });
      }

      document.getElementById('voucher-list').innerHTML = html;

      if (!voucherModalInstance) {
        voucherModalInstance = new bootstrap.Modal(document.getElementById('newUserVoucherModal'));
      }
      voucherModalInstance.show();
    })
    .catch((err) => {
      showNotify('❌ Lỗi', `
        <div>Không tải được voucher.</div>
        <div class="text-muted small mt-1">${err.message}</div>
      `);
    });
}

function setButtonLoading(btn, loading) {
  if (!btn) return;
  if (loading) {
    btn.dataset.oldText = btn.innerHTML;
    btn.innerHTML = 'Đang lưu...';
    btn.disabled = true;
  } else {
    btn.innerHTML = btn.dataset.oldText || 'Lưu voucher';
    btn.disabled = false;
  }
}

function saveVoucher(id) {
  const btn = document.getElementById(`btn-save-${id}`);
  setButtonLoading(btn, true);

  fetch('/event/new-user/save/' + id, {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': getCsrfToken(),
      'Accept': 'application/json'
    }
  })
    .then(async (res) => {
      const text = await res.text();
      let data = {};
      try { data = JSON.parse(text); }
      catch { data = { success: false, message: text || 'Lỗi không xác định' }; }

      // Nếu server trả 401/419/500... vẫn show popup
      if (!res.ok && !data.status) {
        data = { success: false, message: data.message || 'Có lỗi xảy ra. Vui lòng thử lại.' };
      }
      return data;
    })
    .then((data) => {
      // ✅ CHƯA ĐĂNG NHẬP
      if (data.status === 'login_required') {
        showNotify(
          '⚠️ Chưa đăng nhập',
          'Bạn cần đăng nhập để nhận voucher.',
          `
            <a href="{{ route('login') }}" class="btn btn-primary">Đăng nhập</a>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
          `
        );
        setButtonLoading(btn, false);
        return;
      }

      // ✅/❌ THÔNG BÁO KẾT QUẢ
      if (data.success) {
        // disable luôn nút
        if (btn) {
          btn.innerHTML = 'Đã lưu';
          btn.classList.remove('btn-primary');
          btn.classList.add('btn-success');
          btn.disabled = true;
        }

        showNotify('🎉 Thành công', data.message || 'Lưu voucher thành công!');
      } else {
        showNotify('❌ Thất bại', data.message || 'Không thể lưu voucher.');
        setButtonLoading(btn, false);
      }
    })
    .catch((err) => {
      showNotify('❌ Lỗi', `
        <div>Không thể lưu voucher.</div>
        <div class="text-muted small mt-1">${err.message}</div>
      `);
      setButtonLoading(btn, false);
    });
}
</script>

@endsection
