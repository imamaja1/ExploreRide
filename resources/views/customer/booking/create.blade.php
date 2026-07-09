@extends('layouts.app')
@section('title', __('Pesan Sekarang'))
@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb" style="font-size: 0.85rem;">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color: var(--green-600); text-decoration: none;">{{ __('Beranda') }}</a></li>
            <li class="breadcrumb-item active" style="color: var(--gray-500);">{{ __('Pesan') }}</li>
        </ol>
    </nav>

    <h4 class="fw-bold mb-4" style="color: var(--gray-900);">{{ __('Pesan Sekarang') }}</h4>

    <form method="POST" action="{{ route('booking.store') }}">
        @csrf
        <div class="row g-4">
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm" style="border-radius: 14px;">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3" style="color: var(--gray-900);"><i class="bi bi-gear me-2" style="color: var(--green-600);"></i>{{ __('Pilih Layanan') }}</h6>
                        @foreach($services as $service)
                        <label class="d-flex align-items-start gap-3 p-3 rounded-3 mb-2" style="border: 1.5px solid var(--gray-200); cursor: pointer; transition: all 0.15s;" onmouseover="this.style.borderColor='var(--green-300)'" onmouseout="this.style.borderColor=this.querySelector('input').checked?'var(--green-500)':'var(--gray-200)'" id="svc-label-{{ $service->id }}">
                            <input class="form-check-input mt-1" type="radio" name="service_id" value="{{ $service->id }}"
                                {{ old('service_id', request('service_id')) == $service->id ? 'checked' : ($loop->first ? 'checked' : '') }}
                                onchange="togglePackage(this.value); updateSvcStyle();">
                            <div>
                                <strong style="color: var(--gray-800);">{{ $service->name }}</strong>
                                <small class="d-block" style="color: var(--gray-500);">{{ $service->description }}</small>
                            </div>
                        </label>
                        @endforeach
                        @error('service_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror

                        <div class="d-none mt-3" id="packageSection">
                            <hr style="border-color: var(--gray-200);">
                            <h6 class="fw-bold mb-3" style="color: var(--gray-900);"><i class="bi bi-map me-2" style="color: var(--green-600);"></i>{{ __('Pilih Paket Wisata') }}</h6>
                            @foreach($packages as $package)
                            <label class="d-flex align-items-start gap-3 p-3 rounded-3 mb-2" style="border: 1.5px solid var(--gray-200); cursor: pointer;" onmouseover="this.style.borderColor='var(--green-300)'" onmouseout="this.style.borderColor='var(--gray-200)'">
                                <input class="form-check-input mt-1" type="radio" name="tour_package_id" value="{{ $package->id }}" data-price="{{ $package->price }}">
                                <div>
                                    <strong style="color: var(--gray-800);">{{ $package->name }}</strong>
                                    <span class="fw-bold" style="color: var(--green-600);">{{ __('Rp') }} {{ number_format($package->price, 0, ',', '.') }}</span>
                                    <small class="d-block" style="color: var(--gray-500);">{{ $package->duration_days }} {{ __('hari') }}</small>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card border-0 shadow-sm" style="border-radius: 14px;">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3" style="color: var(--gray-900);"><i class="bi bi-calendar me-2" style="color: var(--green-600);"></i>{{ __('Detail Pemesanan') }}</h6>

                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label" style="font-size: 0.85rem; font-weight: 500; color: var(--gray-700);">{{ __('Pilih Mobil') }} <span class="text-danger">*</span></label>
                                <select name="car_id" class="form-select @error('car_id') is-invalid @enderror" required>
                                    <option value="">{{ __('-- Pilih Mobil --') }}</option>
                                    @foreach($cars as $car)
                                    <option value="{{ $car->id }}" data-price="{{ $car->price_per_day }}" {{ (old('car_id', request('car_id')) == $car->id) ? 'selected' : '' }}>
                                        {{ $car->brand }} {{ $car->name }} - {{ __('Rp') }} {{ number_format($car->price_per_day, 0, ',', '.') }}/{{ __('hari') }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('car_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" style="font-size: 0.85rem; font-weight: 500; color: var(--gray-700);">{{ __('Tanggal Mulai') }} <span class="text-danger">*</span></label>
                                <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}" min="{{ date('Y-m-d') }}" required>
                                @error('start_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" style="font-size: 0.85rem; font-weight: 500; color: var(--gray-700);">{{ __('Durasi (hari)') }} <span class="text-danger">*</span></label>
                                <input type="number" name="duration_days" class="form-control @error('duration_days') is-invalid @enderror" value="{{ old('duration_days', 1) }}" min="1" required>
                                @error('duration_days') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" style="font-size: 0.85rem; font-weight: 500; color: var(--gray-700);">{{ __('Lokasi Jemput') }}</label>
                                <input type="text" name="pickup_location" class="form-control" value="{{ old('pickup_location') }}" placeholder="{{ __('Contoh: Bandara, Hotel') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" style="font-size: 0.85rem; font-weight: 500; color: var(--gray-700);">{{ __('Jam Jemput') }}</label>
                                <input type="time" name="pickup_time" class="form-control" value="{{ old('pickup_time') }}">
                            </div>

                            <div class="col-12">
                                <label class="form-label" style="font-size: 0.85rem; font-weight: 500; color: var(--gray-700);">{{ __('Catatan') }}</label>
                                <textarea name="notes" class="form-control" rows="2" placeholder="{{ __('Catatan tambahan (opsional)') }}">{{ old('notes') }}</textarea>
                            </div>
                        </div>

                        <hr style="border-color: var(--gray-200);">

                        <div class="p-3 rounded-3 mb-3" style="background: var(--green-50);">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-semibold" style="color: var(--gray-700);">{{ __('Total Harga') }}</span>
                                <span class="fw-bold" style="color: var(--green-700); font-size: 1.2rem;" id="priceDisplay">{{ __('Rp') }} 0</span>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-green w-100 btn-lg"><i class="bi bi-check-circle me-2"></i>{{ __('Pesan Sekarang') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function togglePackage(serviceId) {
        const pkgSection = document.getElementById('packageSection');
        const service = @json($services);
        const selected = service.find(s => s.id == serviceId);
        pkgSection.classList.toggle('d-none', !(selected && selected.slug === 'paket-wisata'));
    }
    togglePackage(document.querySelector('input[name="service_id"]:checked')?.value);

    function updateSvcStyle() {
        document.querySelectorAll('input[name="service_id"]').forEach(function(el) {
            var label = el.closest('label');
            if (el.checked) {
                label.style.borderColor = 'var(--green-500)';
                label.style.background = 'var(--green-50)';
            } else {
                label.style.borderColor = 'var(--gray-200)';
                label.style.background = 'transparent';
            }
        });
    }
    updateSvcStyle();

    const urlPackageId = new URLSearchParams(window.location.search).get('package_id');
    if (urlPackageId) {
        const pkgService = @json($services);
        const pkgSvc = pkgService.find(s => s.slug === 'paket-wisata');
        if (pkgSvc) {
            const svcRadio = document.querySelector('input[name="service_id"][value="' + pkgSvc.id + '"]');
            if (svcRadio) {
                svcRadio.checked = true;
                togglePackage(pkgSvc.id);
                updateSvcStyle();
            }
        }
        const pkgRadio = document.querySelector('input[name="tour_package_id"][value="' + urlPackageId + '"]');
        if (pkgRadio) { pkgRadio.checked = true; }
    }

    document.querySelectorAll('input[name="service_id"]').forEach(el => {
        el.addEventListener('change', function () { togglePackage(this.value); recalcTotal(); updateSvcStyle(); });
    });
    document.querySelector('select[name="car_id"]')?.addEventListener('change', recalcTotal);
    document.querySelector('input[name="duration_days"]')?.addEventListener('input', recalcTotal);
    document.querySelectorAll('input[name="tour_package_id"]').forEach(el => el.addEventListener('change', recalcTotal));

    function recalcTotal() {
        const carSelect = document.querySelector('select[name="car_id"]');
        const duration = parseInt(document.querySelector('input[name="duration_days"]')?.value || 1);
        const pkgChecked = document.querySelector('input[name="tour_package_id"]:checked');
        let total = 0;

        if (pkgChecked) {
            total = parseFloat(pkgChecked.dataset.price || 0);
        } else if (carSelect?.selectedOptions[0]?.dataset.price) {
            total = parseFloat(carSelect.selectedOptions[0].dataset.price) * duration;
        }

        document.getElementById('priceDisplay').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
    }
    recalcTotal();
</script>
@endpush
