<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 overflow-hidden">
            <div class="p-4 text-white text-center" style="background: var(--er-primary);">
                <h4 class="fw-bold mb-0">{{ __('Masuk') }}</h4>
            </div>
            <div class="modal-body px-4 py-4">
                <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"></button>

                <div id="loginError" class="alert alert-danger d-none"></div>

                <form id="loginForm" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">{{ __('Email') }}</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">{{ __('Password') }}</label>
                        <input type="password" name="password" class="form-control" required>
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
    btn.disabled = true; btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';

    var errorDiv = document.getElementById('loginError');
    errorDiv.classList.add('d-none');

    fetch('{{ route("customer.login") }}', {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams(new FormData(this))
    }).then(function(r) { return r.json(); }).then(function(data) {
        if (data.success) {
            location.reload();
        } else {
            errorDiv.textContent = data.message || '{{ __("Email atau password salah") }}';
            errorDiv.classList.remove('d-none');
            btn.disabled = false; btn.innerHTML = '{{ __("Masuk") }}';
        }
    }).catch(function() {
        errorDiv.textContent = '{{ __("Email atau password salah") }}';
        errorDiv.classList.remove('d-none');
        btn.disabled = false; btn.innerHTML = '{{ __("Masuk") }}';
    });
});
</script>
@endpush
