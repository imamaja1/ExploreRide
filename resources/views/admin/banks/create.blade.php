@extends('layouts.admin')
@section('title', __('Tambah Bank'))
@section('content')
<div class="page-header mb-4">
    <h4 >{{ __('Tambah Bank') }}</h4>
</div>
<div class="card"><div class="card-body">
<form method="POST" action="{{ route('admin.banks.store') }}" enctype="multipart/form-data">@csrf
<div class="row g-3">
    <div class="col-md-4"><label class="form-label">{{ __('Nama Bank') }}</label><input type="text" name="name" class="form-control" value="{{ old('name') }}" required></div>
    <div class="col-md-4"><label class="form-label">{{ __('No. Rekening') }}</label><input type="text" name="account_number" class="form-control" value="{{ old('account_number') }}" required></div>
    <div class="col-md-4"><label class="form-label">{{ __('Atas Nama') }}</label><input type="text" name="account_name" class="form-control" value="{{ old('account_name') }}" required></div>
    <div class="col-md-4"><label class="form-label">{{ __('Logo') }}</label><input type="file" name="logo" class="form-control" accept="image/*"></div>
    <div class="col-md-4 d-flex align-items-end pb-2">
        <div class="form-check">
            <input type="checkbox" name="is_active" class="form-check-input" id="isActiveBnk" value="1" checked>
            <label class="form-check-label" for="isActiveBnk">{{ __('Aktif') }}</label>
        </div>
    </div>
</div>
<hr>
<button type="submit" class="btn btn-primary">{{ __('Simpan') }}</button>
<a href="{{ route('admin.banks.index') }}" class="btn btn-outline-gray">{{ __('Batal') }}</a>
</form>
</div></div>
@endsection
