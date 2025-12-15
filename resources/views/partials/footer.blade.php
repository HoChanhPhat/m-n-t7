<footer class="bg-dark text-light pt-5 pb-4 mt-5">
  <div class="container text-md-left">
    <div class="row">
      {{-- Cột 1 --}}
      <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mb-4">
        <h5 class="text-uppercase fw-bold text-primary">TECHUSED</h5>
        <p>Chuyên mua bán các thiết bị điện tử đã qua sử dụng.</p>
        <p><i class="fas fa-map-marker-alt me-2"></i>123 Đường ABC, TP.HCM</p>
        <p><i class="fas fa-phone-alt me-2"></i>0901.234.567</p>
        <p><i class="fas fa-envelope me-2"></i>support@techused.vn</p>
      </div>

      {{-- Cột 2: Liên kết nhanh --}}
      <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
        <h6 class="text-uppercase fw-bold mb-3">Liên kết</h6>
        <p><a href="{{ url('/') }}" class="text-light text-decoration-none">Trang chủ</a></p>
        <p><a href="{{ url('all_products') }}" class="text-light text-decoration-none">Sản phẩm</a></p>
        <p><a href="{{ url('about') }}" class="text-light text-decoration-none">Giới thiệu</a></p>
        <p><a href="{{ url('contact') }}" class="text-light text-decoration-none">Liên hệ</a></p>
      </div>

      {{-- Cột 3: Hỗ trợ --}}
      <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
        <h6 class="text-uppercase fw-bold mb-3">Hỗ trợ</h6>
        <p><a href="#" class="text-light text-decoration-none">Hướng dẫn mua hàng</a></p>
        <p><a href="{{ url('policy') }}" class="text-light text-decoration-none">Chính sách bảo hành</a></p>
        <p><a href="#" class="text-light text-decoration-none">Chính sách đổi trả</a></p>
        <p><a href="#" class="text-light text-decoration-none">Câu hỏi thường gặp</a></p>
      </div>

      {{-- Cột 4: Mạng xã hội --}}
      <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
        <h6 class="text-uppercase fw-bold mb-3">Theo dõi chúng tôi</h6>

        {{-- Facebook --}}
        <div class="social-group position-relative d-inline-block me-3">
          <i class="fab fa-facebook fa-lg social-icon"></i>
          <div class="member-popup">
            <div><a href="https://www.facebook.com/share/1BuFvaCT4k/" target="_blank">Trương Duy Thành Đạt</a></div>
            <div><a href="https://www.facebook.com/share/1F1zB5Zcpb/" target="_blank">Hồ Chanh Phát</a></div>
            <div><a href="https://www.facebook.com/share/1ArFyZpS2X/" target="_blank">Đặng Hữu Nghĩa</a></div>
            <div><a href="https://www.facebook.com/share/1ZgAaAQ6qp/" target="_blank">Nguyễn Quốc Bảo</a></div>
            <div><a href="https://www.facebook.com/nguyen.thanh.ong.612693/?locale=vi_VN" target="_blank">Nguyễn Thành Đồng</a></div>
          </div>
        </div>

        {{-- Instagram --}}
        <div class="social-group position-relative d-inline-block me-3">
          <i class="fab fa-instagram fa-lg social-icon"></i>
          <div class="member-popup">
            <div><a href="#" target="_blank">Trương Duy Thành Đạt</a></div>
            <div><a href="#" target="_blank">Hồ Chanh Phát</a></div>
            <div><a href="#" target="_blank">Đặng Hữu Nghĩa</a></div>
            <div><a href="#" target="_blank">Nguyễn Quốc Bảo</a></div>
            <div><a href="#" target="_blank">Nguyễn Thành Đồng</a></div>
          </div>
        </div>

        {{-- Gmail --}}
        <div class="social-group position-relative d-inline-block me-3">
          <i class="fas fa-envelope fa-lg social-icon"></i>
          <div class="member-popup">
            <div><a href="mailto:23050165@student.bdu.edu.vn">23050165</a></div>
            <div><a href="mailto:23050142@student.bdu.edu.vn">23050142</a></div>
            <div><a href="mailto:23050138@student.bdu.edu.vn">23050138</a></div>
            <div><a href="mailto:23050141@student.bdu.edu.vn">23050141</a></div>
            <div><a href="mailto:23050158@student.bdu.edu.vn">23050158</a></div>
          </div>
        </div>

        {{-- GitHub --}}
        <div class="social-group position-relative d-inline-block">
          <i class="fab fa-github fa-lg social-icon"></i>
          <div class="member-popup">
            <div><a href="#" target="_blank">Trương Duy Thành Đạt</a></div>
            <div><a href="https://github.com/lemon180205" target="_blank">Hồ Chanh Phát</a></div>
            <div><a href="#" target="_blank">Đặng Hữu Nghĩa</a></div>
            <div><a href="#" target="_blank">Nguyễn Quốc Bảo</a></div>
            <div><a href="https://github.com/NguyenThanhDong13" target="_blank">Nguyễn Thành Đồng</a></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <style>
    .social-group{position:relative;cursor:pointer;}
    .member-popup{
      position:absolute;top:110%;left:50%;transform:translateX(-50%);
      min-width:160px;background:#fff;color:#333;box-shadow:0 0 8px rgba(0,0,0,.15);
      padding:8px 12px;border-radius:8px;display:none;z-index:1000;white-space:nowrap;
    }
    .member-popup a{display:block;text-decoration:none;color:#333;padding:4px 0;transition:color .3s;}
    .member-popup a:hover{color:#007bff;}
    .social-group:hover .member-popup{display:block;}
    .social-icon{font-size:24px;color:#fff;}
  </style>
</footer>
