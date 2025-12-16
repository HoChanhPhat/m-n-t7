@extends('layouts.app')
@section('title', 'Voucher của tôi')

@section('content')
<div class="container py-3">
  <h3 class="fw-bold mb-3">🎟️ Voucher của tôi</h3>

  @if($vouchers->isEmpty())
    <div class="alert alert-info mb-0">Bạn chưa lưu voucher nào.</div>
  @else
    <div class="row g-3">
      @foreach($vouchers as $uv)
        @php $c = $uv->coupon; @endphp
        @if($c)
        <div class="col-md-4">
          <div class="card shadow-sm h-100">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-start">
                <div>
                  <div class="fw-bold fs-5">{{ $c->code }}</div>
                  <div class="text-muted small">{{ $c->description ?? '—' }}</div>
                </div>
                <span class="badge {{ $uv->is_used ? 'bg-secondary' : 'bg-success' }}">
                  {{ $uv->is_used ? 'Đã dùng' : 'Chưa dùng' }}
                </span>
              </div>

              <hr>

              <div class="small">
                Giảm:
                <b>
                  @if($c->type === 'percent')
                    {{ $c->value }}%
                  @else
                    {{ number_format($c->value) }}đ
                  @endif
                </b>
              </div>

              <div class="small text-muted">
                Hạn:
                <b>{{ $c->end_date ? \Carbon\Carbon::parse($c->end_date)->format('d/m/Y') : 'Không giới hạn' }}</b>
              </div>
            </div>
          </div>
        </div>
        @endif
      @endforeach
    </div>
  @endif
</div>
@endsection
