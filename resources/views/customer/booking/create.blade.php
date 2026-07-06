@extends('layouts.app')
@section('title', __('Pesan Sekarang'))
@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4">{{ __('Pesan Sekarang') }}</h2>
    <form method="POST" action="{{ route('booking.store') }}">
        @csrf
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-gear"></i> {{ __('Pilih Layanan') }}</h5>
                        @foreach($services as $service)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="service_id" value="{{ $service->id }}" id="service{{ $service->id }}"
                                {{ old('service_id', request('service_id')) == $service->id ? 'checked' : ($loop->first ? 'checked' : '') }}
                                onchange="togglePackage(this.value)">
                            <label class="form-check-label" for="service{{ $service->id }}">
                                <strong>{{ $service->name }}</strong>
                                <small class="d-block text-muted">{{ $service->description }}</small>
                            </label>
                        </div>
                        @endforeach
                        @error('service_id') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="card mt-3 d-none" id="packageSection">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-map"></i> {{ __('Pilih Paket Wisata') }}</h5>
                        @foreach($packages as $package)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="tour_package_id" value="{{ $package->id }}" id="pkg{{ $package->id }}"
                                data-price="{{ $package->price }}">
                            <label class="form-check-label" for="pkg{{ $package->id }}">
                                <strong>{{ $package->name }}</strong>
                                <span class="text-success">({{ __('Rp') }} {{ number_format($package->price, 0, ',', '.') }})</span>
                                <small class="d-block text-muted">{{ $package->duration_days }} {{ __('hari') }}</small>
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-calendar"></i> {{ __('Detail Pemesanan') }}</h5>

                        <div class="mb-3">
                            <label class="form-label">{{ __('Pilih Mobil') }}</label>
                            <select name="car_id" class="form-select @error('car_id') is-invalid @enderror" required>
                                <option value="">{{ __('-- Pilih Mobil --') }}</option>
                                @foreach($cars as $car)
                                <option value="{{ $car->id }}" data-price="{{ $car->price_per_day }}" {{ old('car_id') == $car->id ? 'selected' : '' }}>
                                    {{ $car->brand }} {{ $car->name }} - {{ __('Rp') }} {{ number_format($car->price_per_day, 0, ',', '.') }}/{{ __('hari') }}
                                </option>
                                @endforeach
                            </select>
                            @error('car_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('Tanggal Mulai') }}</label>
                            <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}" min="{{ date('Y-m-d') }}" required>
                            @error('start_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('Durasi (hari)') }}</label>
                            <input type="number" name="duration_days" class="form-control @error('duration_days') is-invalid @enderror" value="{{ old('duration_days', 1) }}" min="1" required>
                            @error('duration_days') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('Lokasi Jemput') }}</label>
                            <input type="text" name="pickup_location" class="form-control" value="{{ old('pickup_location') }}" placeholder="{{ __('Contoh: Bandara, Hotel, Alamat') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('Jam Jemput') }}</label>
                            <input type="time" name="pickup_time" class="form-control" value="{{ old('pickup_time') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('Catatan') }}</label>
                            <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
                        </div>

                        <div class="bg-success bg-opacity-10 rounded p-3 text-success" id="priceDisplay">
                            <strong>{{ __('Total:') }}</strong> <span>{{ __('Rp') }} 0</span>
                        </div>

                        <button type="submit" class="btn btn-success w-100 btn-lg">{{ __('Pesan Sekarang') }}</button>
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

    document.querySelectorAll('input[name="service_id"]').forEach(el => {
        el.addEventListener('change', function () { togglePackage(this.value); recalcTotal(); });
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

        document.querySelector('#priceDisplay span').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
    }
    recalcTotal();
</script>
@endpush
