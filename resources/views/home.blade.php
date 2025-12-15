@extends('layouts.app')
@section('title', 'Trang chủ')

@section('content')

<!-- Carousel banner -->
<div id="bannerCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
  <div class="carousel-inner">
   <div class="carousel-item active" onclick="openNewUserPopup()" style="cursor:pointer;">
  <img src="{{ asset('images/banner1.jpg') }}" class="d-block w-100" alt="Banner 1">
</div>

    <div class="carousel-item">
      <a href="#"><img src="{{ asset('images/banner2.jpg') }}" class="d-block w-100" alt="Banner 2"></a>
    </div>
    <div class="carousel-item">
      <a href="#"><img src="{{ asset('images/banner3.jpg') }}" class="d-block w-100" alt="Banner 3"></a>
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
          {{-- DÙNG COMPONENT CARD + WISHLIST --}}
          <x-product-card :product="$product" :wishlist="$wishlist" />
      </div>
    @endforeach
  </div>
</section>

<!-- Sản phẩm mới nhất -->
<section class="container my-5">
  <h2 class="text-center mb-4 fw-bold">🆕 Sản phẩm mới nhất</h2>
  <div class="text-center mb-4">
    <a href="{{ route('products.all') }}" class="btn btn-primary">Xem tất cả sản phẩm</a>
  </div>

  <div class="row g-4">
    @foreach($latest as $product)
      <div class="col-md-3 mb-4">
          {{-- DÙNG LẠI COMPONENT CARD --}}
          <x-product-card :product="$product" :wishlist="$wishlist" />
      </div>
    @endforeach
  </div>
</section>

<!-- Danh mục sản phẩm -->
<div class="container mt-5">
  <h4 class="text-center mb-4 fw-bold">Danh mục sản phẩm</h4>
  <div class="row">
    <!-- Điện thoại -->
    <div class="col-md-4 mb-3">
      <a href="{{ route('category.show', 1) }}" class="text-decoration-none text-dark">
        <div class="card h-100 shadow-sm hover-shadow">
          <img src="{{ asset('images/phone.jpg') }}" class="card-img-top" alt="Điện thoại">
          <div class="card-body text-center">
            <h5 class="card-title fw-bold">Điện thoại</h5>
            <p class="card-text">Mua bán điện thoại cũ chất lượng cao.</p>
          </div>
        </div>
      </a>
    </div>

    <!-- Laptop -->
    <div class="col-md-4 mb-3">
      <a href="{{ route('category.show', 2) }}" class="text-decoration-none text-dark">
        <div class="card h-100 shadow-sm hover-shadow">
          <img src="{{ asset('images/laptop.jpg') }}" class="card-img-top" alt="Laptop">
          <div class="card-body text-center">
            <h5 class="card-title fw-bold">Laptop</h5>
            <p class="card-text">Thiết bị đáng tin cậy cho công việc và học tập.</p>
          </div>
        </div>
      </a>
    </div>

    <!-- Phụ kiện -->
    <div class="col-md-4 mb-3">
      <a href="{{ route('category.show', 3) }}" class="text-decoration-none text-dark">
        <div class="card h-100 shadow-sm hover-shadow">
          <img src="{{ asset('images/accessory.jpg') }}" class="card-img-top" alt="Phụ kiện">
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

// Auto scroll nhẹ cho brand-scroll
setInterval(() => {
  const slider = document.querySelector('.brand-scroll');
  if (slider) {
    if (slider.scrollLeft + slider.clientWidth >= slider.scrollWidth - 5) {
      slider.scrollTo({ left: 0, behavior: 'smooth' });
    } else {
      slider.scrollBy({ left: 2, behavior: 'smooth' });
    }
  }
}, 50);
</script>
<!-- Popup voucher người mới -->
<div class="modal fade" id="newUserVoucherModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3">

            <h4 class="mb-3 fw-bold">🎉 Voucher dành cho người mới</h4>

            <div id="voucher-list">
                <!-- JS sẽ đổ voucher vào đây -->
            </div>

        </div>
    </div>
</div>

<script>
function openNewUserPopup() {
    fetch('/event/new-user/vouchers')
        .then(res => res.json())
        .then(data => {

            let html = '';

            if (data.length === 0) {
                html = '<p>Không có voucher nào dành cho người mới.</p>';
            } else {
                data.forEach(v => {
                    html += `
                        <div class="border rounded p-2 mb-2">
                            <p class="fw-bold">${v.code}</p>
                            <p>${v.description ?? ''}</p>
                            <button class="btn btn-primary btn-sm" onclick="saveVoucher(${v.id})">
                                Lưu voucher
                            </button>
                        </div>
                    `;
                });
            }

            document.getElementById('voucher-list').innerHTML = html;

            var modal = new bootstrap.Modal(document.getElementById('newUserVoucherModal'));
            modal.show();
        });
}

function saveVoucher(id) {
    fetch('/event/new-user/save/' + id, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
    });
}
</script>

@endsection
