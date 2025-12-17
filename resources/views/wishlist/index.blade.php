@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3 class="fw-bold mb-4">Danh sách yêu thích</h3>

    <div id="wishlist-empty" class="text-muted">
        Bạn chưa có sản phẩm yêu thích nào.
    </div>

    <div class="row" id="wishlist-grid" style="display:none;"></div>
</div>

<script>
(function () {
    const KEY = "wishlist_product_ids";
    const ids = JSON.parse(localStorage.getItem(KEY) || "[]");

    if (!ids.length) return;

    fetch(`/wishlist/products?ids=${ids.join(',')}`, {
        headers: { "Accept": "application/json" }
    })
    .then(res => res.json())
    .then(products => {
        if (!products.length) return;

        document.getElementById("wishlist-empty").style.display = "none";

        const grid = document.getElementById("wishlist-grid");
        grid.style.display = "";

        grid.innerHTML = products.map(p => `
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow-sm position-relative product-card"
                     style="cursor:pointer;"
                     onclick="window.location='/products/${p.id}'">

                    <!-- ❤️ ICON -->
                    <i class="fa fa-heart wishlist-icon"
                       data-product-id="${p.id}"
                       onclick="event.stopPropagation(); toggleWishlist(${p.id}, this); removeFromWishlist(${p.id})"
                       style="
                            position:absolute;
                            top:10px; right:10px;
                            font-size:22px;
                            cursor:pointer;
                            color:red;
                       ">
                    </i>

                    <!-- ẢNH -->
                    <img src="/storage/${p.image}"
                         class="card-img-top"
                         alt="${p.name}">

                    <div class="card-body text-center">
                        <h5 class="card-title text-truncate">${p.name}</h5>
                        <p class="fw-bold text-danger">
                            ${new Intl.NumberFormat('vi-VN').format(p.price)} đ
                        </p>

                        <div class="d-flex gap-2 mt-2">
                            <button class="btn btn-primary btn-sm w-50"
                                onclick="event.stopPropagation(); buyNow(${p.id})">
                                Mua ngay
                            </button>

                            <button class="btn btn-success btn-sm w-50"
                                onclick="event.stopPropagation(); addToCart(${p.id})">
                                <i class="bi bi-cart-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `).join("");
    });

    // ❌ Bỏ khỏi wishlist
    window.removeFromWishlist = function(id) {
        let list = JSON.parse(localStorage.getItem(KEY) || "[]");
        list = list.filter(x => Number(x) !== Number(id));
        localStorage.setItem(KEY, JSON.stringify(list));

        // reload lại trang wishlist
        setTimeout(() => location.reload(), 150);
    };
})();
</script>
@endsection
