<form id="adminlte-logout-form" action="{{ url(config('adminlte.logout_url', 'logout')) }}" method="POST" class="d-none">
    @csrf
</form>

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const a = document.getElementById('sidebar-logout');
  if (!a) return;

  a.addEventListener('click', function (e) {
    e.preventDefault();
    document.getElementById('adminlte-logout-form').submit();
  });
});
</script>
@endpush
