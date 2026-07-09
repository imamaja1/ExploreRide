<div class="modal fade" id="testimonialModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-4">
                <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                <h4 class="text-center fw-bold mb-4 text-success">{{ __('Tulis Testimoni') }}</h4>

                <div id="testimonialError" class="alert alert-danger d-none"></div>
                <div id="testimonialSuccess" class="alert alert-success d-none"></div>

                <form id="testimonialForm" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="testimonialName">{{ __('Nama') }}</label>
                        <input type="text" name="name" class="form-control" id="testimonialName" value="{{ Auth::guard('customer')->user()->name ?? '' }}" {{ Auth::guard('customer')->check() ? 'readonly' : '' }} required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Rating') }}</label>
                        <div class="rating-stars fs-3 text-warning" id="ratingStars">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star" data-value="{{ $i }}" style="cursor: pointer;"></i>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="ratingInput" value="5">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Pesan') }}</label>
                        <textarea name="message" class="form-control" rows="4" required minlength="10" placeholder="{{ __('Ceritakan pengalaman Anda...') }}"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success w-100" id="testimonialBtn">{{ __('Kirim Testimoni') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.querySelectorAll('#ratingStars i').forEach(function(star) {
        star.addEventListener('click', function() {
            var val = this.dataset.value;
            document.getElementById('ratingInput').value = val;
            document.querySelectorAll('#ratingStars i').forEach(function(s, idx) {
                s.className = idx < val ? 'bi bi-star-fill' : 'bi bi-star';
            });
        });
    });

    document.getElementById('testimonialForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        var btn = document.getElementById('testimonialBtn');
        btn.disabled = true; btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';

        var errorDiv = document.getElementById('testimonialError');
        var successDiv = document.getElementById('testimonialSuccess');
        errorDiv.classList.add('d-none');
        successDiv.classList.add('d-none');

        fetch('{{ route("testimonials.store") }}', {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams(new FormData(this))
        }).then(function(r) { return r.json(); }).then(function(data) {
            if (data.success) {
                successDiv.textContent = data.message;
                successDiv.classList.remove('d-none');
                document.getElementById('testimonialForm').reset();
                btn.disabled = false; btn.innerHTML = '{{ __("Kirim Testimoni") }}';
                setTimeout(function() { location.reload(); }, 2000);
            } else {
                errorDiv.textContent = '';
                var msgs = [];
                if (data.errors) { for (var k in data.errors) { msgs = msgs.concat(data.errors[k]); } }
                else { msgs.push(data.message || '{{ __("Terjadi kesalahan") }}'); }
                msgs.forEach(function(msg) {
                    var p = document.createElement('div');
                    p.textContent = msg;
                    errorDiv.appendChild(p);
                });
                errorDiv.classList.remove('d-none');
                btn.disabled = false; btn.innerHTML = '{{ __("Kirim Testimoni") }}';
            }
        }).catch(function() {
            errorDiv.textContent = '{{ __("Terjadi kesalahan") }}';
            errorDiv.classList.remove('d-none');
            btn.disabled = false; btn.innerHTML = '{{ __("Kirim Testimoni") }}';
        });
    });
</script>
@endpush
