<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 overflow-hidden">
            <div class="p-4 text-white text-center" style="background: var(--er-primary);">
                <h4 class="fw-bold mb-0">{{ __('Masuk') }}</h4>
            </div>
            <div class="modal-body px-4 py-4">
                <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>

                <div id="loginError" class="alert alert-danger d-none"></div>

                <form id="loginForm" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="loginEmail">{{ __('Email') }}</label>
                        <input type="email" name="email" class="form-control" id="loginEmail" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="loginPassword">{{ __('Password') }}</label>
                        <input type="password" name="password" class="form-control" id="loginPassword" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="rememberModal">
                        <label class="form-check-label" for="rememberModal">{{ __('Ingat saya') }}</label>
                    </div>
                    <button type="submit" class="btn btn-success w-100 fw-bold py-2" id="loginBtn">{{ __('Masuk') }}</button>
                </form>

                <div class="text-center my-3"><small class="text-muted">{{ __('atau') }}</small></div>

                <a href="{{ route('customer.google.login') }}" class="btn btn-outline-dark w-100 mb-3">
                    <i class="bi bi-google"></i> {{ __('Masuk dengan Google') }}
                </a>

                <hr>
                <p class="text-center mb-0">{{ __('Belum punya akun?') }}
                    <a href="#" class="text-success fw-semibold" onclick="switchModal('loginModal', 'registerModal'); return false;">{{ __('Daftar') }}</a>
                </p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('loginForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    var btn = document.getElementById('loginBtn');
    var btnText = btn.innerHTML;
    btn.disabled = true; btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';

    var errorDiv = document.getElementById('loginError');
    errorDiv.textContent = '';
    errorDiv.classList.add('d-none');

    var csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    fetch('{{ route("customer.login") }}', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams(new FormData(this))
    }).then(function(r) {
        if (r.status === 419) {
            return r.text().then(function() {
                errorDiv.textContent = '{{ __("Sesi habis. Halaman akan direfresh...") }}';
                errorDiv.classList.remove('d-none');
                setTimeout(function() { location.reload(); }, 1500);
                throw new Error('csrf');
            });
        }
        if (r.status === 429) {
            return r.text().then(function() {
                errorDiv.textContent = '{{ __("Terlalu banyak percobaan. Silakan tunggu 1 menit.") }}';
                errorDiv.classList.remove('d-none');
                btn.disabled = false; btn.innerHTML = btnText;
                throw new Error('throttle');
            });
        }
        return r.json().then(function(data) { return { status: r.status, data: data }; });
    }).then(function(result) {
        if (result.data.success) {
            location.reload();
        } else {
            errorDiv.textContent = result.data.message || '{{ __("Email atau password salah") }}';
            errorDiv.classList.remove('d-none');
            btn.disabled = false; btn.innerHTML = btnText;
        }
    }).catch(function(err) {
        if (err.message === 'csrf' || err.message === 'throttle') return;
        errorDiv.textContent = '{{ __("Gagal terhubung ke server. Periksa koneksi internet Anda.") }}';
        errorDiv.classList.remove('d-none');
        btn.disabled = false; btn.innerHTML = btnText;
    });
});
</script>
@endpush
