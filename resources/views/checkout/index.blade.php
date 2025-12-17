@extends('layouts.app')

@section('title', 'Thanh toán đơn hàng')

@section('content')
<div class="container py-4">

    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf

        <div class="row">

            {{-- ========================================================= --}}
            {{--                CỘT TRÁI: THÔNG TIN + THANH TOÁN          --}}
            {{-- ========================================================= --}}
            <div class="col-md-7">

                <h4 class="mb-3 fw-bold">Thông tin nhận hàng</h4>

                {{-- Email --}}
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="customer_email" class="form-control"
                           placeholder="Nhập email (tùy chọn)">
                </div>

                {{-- Họ tên --}}
                <div class="mb-3">
                    <label class="form-label">Họ và tên</label>
                    <input type="text" name="customer_name" class="form-control" required>
                </div>

                {{-- Số điện thoại --}}
                <div class="mb-3">
                    <label class="form-label">Số điện thoại</label>
                   <input type="text" name="customer_phone" id="customer_phone" class="form-control" required>

                </div>

                {{-- Địa chỉ --}}
                <div class="mb-3">
                    <label class="form-label">Địa chỉ</label>
                    <textarea name="customer_address" class="form-control" rows="2" required></textarea>
                </div>

                {{-- Tỉnh / huyện / xã --}}
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tỉnh / Thành</label>
                        <select id="province" name="province_code" class="form-select">
                            <option value="">-- Chọn tỉnh --</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Quận / Huyện</label>
                       <select id="district" name="district_code" class="form-select">
                            <option value="">-- Chọn huyện --</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Phường / Xã</label>
                       <select id="ward" name="ward_code" class="form-select">
                            <option value="">-- Chọn xã --</option>
                        </select>
                    </div>
                </div>

                {{-- ==================== THANH TOÁN ==================== --}}
                <h4 class="mt-4 mb-2 fw-bold">Thanh toán</h4>

                <div class="border rounded p-3">

                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="payment_method" id="cod"
                               value="COD" checked>
                        <label class="form-check-label" for="cod">
                            Thanh toán khi nhận hàng (COD)
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_method" id="bank"
                               value="BANK">
                        <label class="form-check-label" for="bank">
                            Chuyển khoản ngân hàng
                        </label>
                    </div>

                  {{-- BOX BANK INFO --}}
<div id="bank-info" class="mt-3 p-3 border rounded bg-light" style="display:none;">
    <h6 class="fw-bold mb-2">Thông tin chuyển khoản</h6>

    <p class="mb-1">Ngân hàng: <strong>Vietcombank</strong></p>
    <p class="mb-1">Số tài khoản: <strong>123456789</strong></p>
    <p class="mb-1">Tên tài khoản: <strong>TechStore</strong></p>

    <hr class="my-2">

    <p class="mb-1">
        <strong>Nội dung chuyển khoản:</strong>
        <span id="transfer-content" class="text-danger small d-block mt-1">
            TECHSTORE_SDT
        </span>
    </p>

    <small class="text-muted">
        Lưu ý: Vui lòng chuyển đúng nội dung để hệ thống/CSKH đối soát nhanh.
    </small>
</div>


                </div>

            </div> {{-- end col-md-7 --}}

   {{-- ========================================================= --}}
{{--                CỘT PHẢI: TÓM TẮT ĐƠN HÀNG                --}}
{{-- ========================================================= --}}
<div class="col-md-5">

    <h4 class="fw-bold mb-3">Đơn hàng của bạn</h4>



    <div class="border rounded p-3 bg-light">

        @foreach ($cart as $item)
        <div class="d-flex justify-content-between mb-2">
            <div>
                <strong>{{ $item['name'] }}</strong><br>
                <small>x {{ $item['quantity'] }}</small>
            </div>
            <div class="text-end fw-bold text-danger">
                {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} đ
            </div>
        </div>
        @endforeach

        <hr>
    {{-- TỔNG GIỎ HÀNG GỐC --}}
<div class="d-flex justify-content-between mb-2">
    <span>Tổng giá trị đơn hàng:</span>
    <span class="fw-bold text-danger">
        {{ number_format($total, 0, ',', '.') }} đ
    </span>
</div>

<hr>


       {{-- MÃ GIẢM GIÁ: chọn voucher dạng scroll --}}
<div class="mb-3">
    <label class="fw-bold">Mã giảm giá</label>

   <div class="d-flex gap-2 align-items-stretch">
    <input type="text"
           id="coupon_code"
           class="form-control"
           placeholder="Chọn voucher hoặc nhập mã"
           value="{{ session('coupon.code') ?? '' }}">

    <div class="dropdown">
        <button type="button"
                class="btn btn-primary dropdown-toggle h-100"
                data-bs-toggle="dropdown" aria-expanded="false"
                style="min-width: 160px;">
            Chọn voucher
        </button>

        <ul class="dropdown-menu dropdown-menu-end p-2 shadow"
            style="width: 360px; max-height: 280px; overflow-y: auto;">
            @forelse($myVouchers as $uv)
                @php $c = $uv->coupon; @endphp
                @if($c)
                    <li>
                        <button type="button"
                                class="dropdown-item rounded py-2"
                                onclick="selectVoucher('{{ $c->code }}')">
                            <div class="fw-bold">{{ $c->code }}</div>
                            <div class="small text-muted">
                                @if($c->type === 'percent')
                                    Giảm {{ $c->value }}%
                                @else
                                    Giảm {{ number_format($c->value, 0, ',', '.') }} đ
                                @endif
                                • Hạn:
                                {{ $c->end_date ? \Carbon\Carbon::parse($c->end_date)->format('d/m/Y') : 'Không giới hạn' }}
                            </div>
                        </button>
                    </li>
                @endif
            @empty
                <li class="px-2 py-2 text-muted">Bạn chưa có voucher nào.</li>
            @endforelse
        </ul>
    </div>
</div>


    <small id="coupon_message" class="mt-2 d-block"></small>
</div>

<script>
document.getElementById("coupon_code")?.addEventListener("keydown", function(e){
    if (e.key === "Enter") {
        e.preventDefault();
        applyCoupon();
    }
});

function applyCoupon() {
    const code = document.getElementById("coupon_code").value.trim();

    if (!code) {
        const msg = document.getElementById("coupon_message");
        msg.className = "text-danger";
        msg.innerHTML = "Vui lòng chọn hoặc nhập mã giảm giá.";
        return;
    }

    fetch("{{ route('checkout.applyCoupon') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ coupon: code })
    })
    .then(res => res.json())
    .then(data => {
        let msg = document.getElementById("coupon_message");

        if (data.error) {
            msg.className = "text-danger";
            msg.innerHTML = data.error;
        } else {
            msg.className = "text-success";
            msg.innerHTML = data.success;

            document.getElementById("total_amount").innerHTML =
                new Intl.NumberFormat().format(data.final_total) + " đ";
        }
    });
}

function selectVoucher(code) {
    document.getElementById("coupon_code").value = code;
    applyCoupon(); // ✅ click là auto áp dụng
}
</script>


        <script>
        function applyCoupon() {
            const code = document.getElementById("coupon_code").value;

            fetch("{{ route('checkout.applyCoupon') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ coupon: code })
            })
            .then(res => res.json())
            .then(data => {
                let msg = document.getElementById("coupon_message");

                if (data.error) {
                    msg.className = "text-danger";
                    msg.innerHTML = data.error;
                } else {
                    msg.className = "text-success";
                    msg.innerHTML = data.success;

                    // cập nhật tổng tiền ngay lập tức
                    document.getElementById("total_amount").innerHTML =
                        new Intl.NumberFormat().format(data.final_total) + " đ";
                }
            });
        }
        </script>

        {{-- TỔNG CỘNG --}}
        <div class="d-flex justify-content-between fs-5 fw-bold text-danger mt-3">
            <span>Tổng cộng:</span>
            <span id="total_amount">
                {{ number_format($finalTotal, 0, ',', '.') }} đ
            </span>
        </div>

        {{-- Nút submit --}}
        <button type="submit" class="btn btn-success w-100 mt-3 py-2 fw-bold">
            Xác nhận đặt hàng
        </button>

    </div>
</div>
{{-- end col-md-5 --}}

        </div>

    </form>
</div>

{{-- ========================= LOAD JSON ========================= --}}
<script>
let provinces = [];

const provinceSelect = document.getElementById("province");
const districtSelect = document.getElementById("district");
const wardSelect     = document.getElementById("ward");

fetch("{{ asset('vn_provinces.json') }}")
  .then(res => res.json())
  .then(data => {
    provinces = data;

    provinceSelect.innerHTML = `<option value="">-- Chọn tỉnh --</option>`;
    data.forEach((p, pIndex) => {
      provinceSelect.innerHTML += `<option value="${pIndex}">${p.name}</option>`;
    });
  })
  .catch(err => console.error("Load vn_provinces.json lỗi:", err));

provinceSelect.addEventListener("change", function () {
  const pIndex = this.value;

  districtSelect.innerHTML = `<option value="">-- Chọn huyện --</option>`;
  wardSelect.innerHTML     = `<option value="">-- Chọn xã --</option>`;

  if (pIndex === "") return;

  const p = provinces[Number(pIndex)];
  if (!p || !p.districts) return;

  p.districts.forEach((d, dIndex) => {
    districtSelect.innerHTML += `<option value="${dIndex}">${d.name}</option>`;
  });
});

districtSelect.addEventListener("change", function () {
  const pIndex = provinceSelect.value;
  const dIndex = this.value;

  wardSelect.innerHTML = `<option value="">-- Chọn xã --</option>`;

  if (pIndex === "" || dIndex === "") return;

  const p = provinces[Number(pIndex)];
  const d = p?.districts?.[Number(dIndex)];
  if (!d || !d.wards) return;

  d.wards.forEach((w, wIndex) => {
    wardSelect.innerHTML += `<option value="${wIndex}">${w.name}</option>`;
  });
});
</script>







<script>
document.addEventListener("DOMContentLoaded", function () {
    const codRadio = document.getElementById("cod");
    const bankRadio = document.getElementById("bank");
    const bankInfo = document.getElementById("bank-info");

    const phoneInput = document.getElementById("customer_phone");
    const transferContent = document.getElementById("transfer-content");

    function updateTransferContent() {
        const phone = (phoneInput?.value || "").trim();
        transferContent.textContent = phone ? `TECHSTORE_${phone}` : "TECHSTORE_SDT";
    }

    function toggleBankInfo() {
        if (bankRadio.checked) {
            bankInfo.style.display = "block";
            updateTransferContent();
        } else {
            bankInfo.style.display = "none";
        }
    }

    codRadio.addEventListener("change", toggleBankInfo);
    bankRadio.addEventListener("change", toggleBankInfo);

    phoneInput.addEventListener("input", function(){
        if (bankRadio.checked) updateTransferContent();
    });

    // init
    toggleBankInfo();
});
</script>



@endsection
