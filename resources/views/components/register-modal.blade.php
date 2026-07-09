<div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 overflow-hidden">
            <div class="p-4 text-white text-center" style="background: var(--er-primary);">
                <h4 class="fw-bold mb-0">{{ __('Daftar Akun') }}</h4>
            </div>
            <div class="modal-body px-4 py-4">
                <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"></button>

                <div id="registerError" class="alert alert-danger d-none"></div>

                <form id="registerForm" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">{{ __('Nama Lengkap') }}</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">{{ __('Email') }}</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">{{ __('No. Telepon') }}</label>
                        <input type="text" name="phone" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">{{ __('Password') }}</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">{{ __('Konfirmasi Password') }}</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100 fw-bold py-2" id="registerBtn">{{ __('Daftar') }}</button>
                </form>

                <div class="text-center my-3"><small class="text-muted">{{ __('atau') }}</small></div>

                <a href="{{ route('customer.google.login') }}" class="btn btn-outline-dark w-100 mb-3">
                    <i class="bi bi-google"></i> {{ __('Daftar dengan Google') }}
                </a>

                <hr>
                <p class="text-center mb-0">{{ __('Sudah punya akun?') }}
                    <a href="#" class="text-success fw-semibold" onclick="switchModal('registerModal', 'loginModal'); return false;">{{ __('Masuk') }}</a>
                </p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('registerForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    var btn = document.getElementById('registerBtn');
    btn.disabled = true; btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';

    var errorDiv = document.getElementById('registerError');
    errorDiv.classList.add('d-none');

    fetch('{{ route("customer.register") }}', {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams(new FormData(this))
    }).then(function(r) { return r.json(); }).then(function(data) {
        if (data.success) {
            location.reload();
        } else {
            if (data.errors) {
                errorDiv.textContent = '';
                Object.values(data.errors).flat().forEach(function(msg) {
                    var p = document.createElement('div');
                    p.textContent = msg;
                    errorDiv.appendChild(p);
                });
            } else {
                errorDiv.textContent = data.message || '{{ __("Email atau password salah") }}';
            }
            errorDiv.classList.remove('d-none');
            btn.disabled = false; btn.innerHTML = '{{ __("Daftar") }}';
        }
    }).catch(function() {
        errorDiv.textContent = '{{ __("Email atau password salah") }}';
        errorDiv.classList.remove('d-none');
        btn.disabled = false; btn.innerHTML = '{{ __("Daftar") }}';
    });
});
</script>
@endpush
