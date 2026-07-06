@extends('layouts.admin')
@section('title', __('Mobil'))
@section('content')
<div class="page-title-border">
    <h4 class="page-title">{{ __('Mobil') }}</h4>
    <a href="{{ route('admin.cars.create') }}" class="btn btn-success"><i class="bi bi-plus-lg"></i> {{ __('Tambah Mobil') }}</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>{{ __('Foto') }}</th>
                        <th>{{ __('Nama') }}</th>
                        <th>{{ __('Plat Nomor') }}</th>
                        <th>{{ __('Harga/hari') }}</th>
                        <th>{{ __('Transmisi') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Aksi') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cars as $car)
                    <tr>
                        <td>
                            @if($car->main_photo)
                                <img src="{{ asset('storage/' . $car->main_photo) }}" style="width: 60px; height: 40px; object-fit: cover;" class="rounded">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $car->brand }} {{ $car->name }}</td>
                        <td>{{ $car->plate_number }}</td>
                        <td>Rp {{ number_format($car->price_per_day, 0, ',', '.') }}</td>
                        <td>{{ __($car->transmission) }}</td>
                        <td>
                            <span class="badge rounded-pill bg-{{ $car->is_active ? 'success' : 'danger' }}">
                                {{ $car->is_active ? __('Aktif') : __('Nonaktif') }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.cars.edit', $car) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                             <form method="POST" action="{{ route('admin.cars.destroy', $car) }}" class="d-inline" data-confirm="{{ __('Hapus mobil ini?') }}">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="mt-3 d-flex justify-content-center">{{ $cars->links() }}</div>
@endsection
