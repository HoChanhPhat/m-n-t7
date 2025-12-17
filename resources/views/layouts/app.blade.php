<!DOCTYPE html> 
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'TechStore')</title>
<!-- FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>

{{-- NAVBAR --}}
@include('partials.navbar')

<style>
body {
    padding-top: 70px;
}
</style>

{{-- MAIN CONTENT --}}
<main class="container my-4">
    @yield('content')
</main>

@include('partials.footer')

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


<!-- ======================= -->
<!--     POPUP SHOPEE       -->
<!-- ======================= -->
<div id="cart-popup" style="
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: rgba(0,0,0,0.85);
    color: white;
    padding: 25px 40px;
    border-radius: 12px;
    text-align: center;
    display: none;
    z-index: 9999;
">
    <div style="
        width: 60px;
        height: 60px;
        margin: 0 auto 10px;
        background: #0fda66;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    ">
        <i class="bi bi-check-lg" style="font-size: 32px; color:white;"></i>
    </div>

    <span style="font-size: 18px;">Sản phẩm đã được thêm vào Giỏ hàng</span>
</div>

<script>
function showPopup() {
    const popup = document.getElementById("cart-popup");
    popup.style.display = "block";
    popup.style.opacity = "0";

    popup.animate([{ opacity: 0 }, { opacity: 1 }], {
        duration: 200,
        fill: "forwards"
    });

    setTimeout(() => {
        popup.animate([{ opacity: 1 }, { opacity: 0 }], {
            duration: 300,
            fill: "forwards"
        });

        setTimeout(() => popup.style.display = "none", 300);
    }, 1500);
}
</script>


<!-- ======================= -->
<!--     ADD TO CART JS      -->
<!-- ======================= -->
<script>
function addToCart(id) {
    fetch("/cart/add/" + id, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ quantity: 1 })
    })
    .then(res => res.json())
    .then(data => {

        // Cập nhật badge giỏ hàng
        const badge = document.getElementById("cart-badge");
        if (badge && data.cart_count !== undefined) {
            badge.innerText = data.cart_count;
            badge.classList.remove("d-none");
        }

        // Hiện popup kiểu Shopee
        showPopup();
    })
    .catch(err => console.error("Lỗi addToCart:", err));
}
</script>

<script>
function toggleWishlist(productId, el) {
  fetch(`/wishlist/toggle/${productId}`, {
    method: "POST",
    headers: {
      "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
      "Accept": "application/json",
    },
  })
  .then(r => r.json())
  .then(data => {
    // update màu tim nếu click từ icon trên card
    if (el && el.classList && el.classList.contains('wishlist-icon')) {
      el.style.color = (data.status === 'added') ? 'red' : '#ccc';
    }

    // update badge wishlist nếu bạn có (đặt id="wishlistCount")
    const badge = document.getElementById("wishlistCount");
    if (badge) badge.textContent = data.wishlist_count;

    // nếu đang ở trang /wishlist và bấm "Bỏ yêu thích" thì reload
    if (location.pathname.includes('/wishlist') && data.status === 'removed') {
      location.reload();
    }
  });
}
</script>


<script>
function buyNow(id) {
    fetch("/cart/add/" + id, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ quantity: 1 })
    })
    .then(res => res.json())
    .then(() => {
        window.location.href = "/cart"; 
    })
    .catch(err => console.error("BuyNow error:", err));
}
</script>
<script>
function buyNow(productId) {
    const qty = document.getElementById("quantity")?.value ?? 1;

    fetch("/cart/add/" + productId, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ quantity: qty })
    })
    .then(res => res.json())
    .then(data => {
        window.location.href = "/checkout/checkout"; // chuyển sang trang thanh toán
    })
    .catch(err => console.error("BuyNow error:", err));
}
</script>

</body>
</html>



<script>
(function () {
  const KEY = "wishlist_product_ids";

  function getWishlist() {
    try { return JSON.parse(localStorage.getItem(KEY) || "[]"); }
    catch { return []; }
  }

  function setWishlist(arr) {
    localStorage.setItem(KEY, JSON.stringify(arr));
  }

  // 👉 hàm này được gọi từ product-card
  window.toggleWishlist = function(productId, iconEl) {
    let list = getWishlist();

    if (list.includes(productId)) {
      list = list.filter(id => id !== productId);
      if (iconEl) iconEl.style.color = "#ccc";
    } else {
      list.push(productId);
      if (iconEl) iconEl.style.color = "red";
    }

    setWishlist(list);
    updateWishlistBadge();
  }

  function paintHearts() {
    const list = getWishlist();
    document.querySelectorAll(".wishlist-icon[data-product-id]").forEach(el => {
      const id = Number(el.dataset.productId);
      el.style.color = list.includes(id) ? "red" : "#ccc";
    });
  }

  function updateWishlistBadge() {
    const list = getWishlist();
    const badge = document.getElementById("wishlistCount");
    if (badge) badge.textContent = list.length;
  }

  document.addEventListener("DOMContentLoaded", function () {
    paintHearts();
    updateWishlistBadge();
  });

  // cho trang wishlist dùng sau
  window.__getWishlistIds = getWishlist;
})();
</script>
