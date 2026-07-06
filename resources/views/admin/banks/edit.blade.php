@extends('layouts.admin')
@section('title', __('Edit Bank'))
@section('content')
<div class="page-title-border mb-4">
    <h4 class="page-title">{{ __('Edit Bank') }}</h4>
</div>
<div class="card"><div class="card-body">
<form method="POST" action="{{ route('admin.banks.update', $bank) }}" enctype="multipart/form-data">@csrf @method('PUT')
<div class="row g-3">
    <div class="col-md-4"><label class="form-label">{{ __('Nama Bank') }}</label><input type="text" name="name" class="form-control" value="{{ old('name', $bank->name) }}" required></div>
    <div class="col-md-4"><label class="form-label">{{ __('No. Rekening') }}</label><input type="text" name="account_number" class="form-control" value="{{ old('account_number', $bank->account_number) }}" required></div>
    <div class="col-md-4"><label class="form-label">{{ __('Atas Nama') }}</label><input type="text" name="account_name" class="form-control" value="{{ old('account_name', $bank->account_name) }}" required></div>
    <div class="col-md-4"><label class="form-label">{{ __('Logo') }}</label><input type="file" name="logo" class="form-control" accept="image/*"></div>
    <div class="col-md-4"><div class="form-check mt-4"><input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1" {{ old('is_active', $bank->is_active) ? 'checked' : '' }}>
    <label class="form-check-label" for="is_active">{{ __('Aktif') }}</label></div></div>
</div>
<hr>
<button type="submit" class="btn btn-success">{{ __('Update') }}</button>
<a href="{{ route('admin.banks.index') }}" class="btn btn-secondary">{{ __('Batal') }}</a>
</form>
</div></div>
@endsection
