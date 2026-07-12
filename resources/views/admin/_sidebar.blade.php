<div class="sidebar-section">
    <a class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
        <i class="bi bi-grid-1x2"></i> {{ __('Dashboard') }}
    </a>
</div>

<div class="sidebar-section">
    <div class="sidebar-section-title">{{ __('Transaksi') }}</div>
    <a class="sidebar-item {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}" href="{{ route('admin.bookings.index') }}">
        <i class="bi bi-receipt"></i> {{ __('Pesanan') }}
    </a>
</div>

<div class="sidebar-section">
    <div class="sidebar-section-title">{{ __('Kendaraan & Driver') }}</div>
    <a class="sidebar-item {{ request()->routeIs('admin.cars.*') ? 'active' : '' }}" href="{{ route('admin.cars.index') }}">
        <i class="bi bi-truck"></i> {{ __('Mobil') }}
    </a>
    <a class="sidebar-item {{ request()->routeIs('admin.drivers.*') ? 'active' : '' }}" href="{{ route('admin.drivers.index') }}">
        <i class="bi bi-people"></i> {{ __('Driver') }}
    </a>
</div>

<div class="sidebar-section">
    <div class="sidebar-section-title">{{ __('Wisata') }}</div>
    <a class="sidebar-item {{ request()->routeIs('admin.tour-packages.*') ? 'active' : '' }}" href="{{ route('admin.tour-packages.index') }}">
        <i class="bi bi-map"></i> {{ __('Paket Wisata') }}
    </a>
    <a class="sidebar-item {{ request()->routeIs('admin.destinations.*') ? 'active' : '' }}" href="{{ route('admin.destinations.index') }}">
        <i class="bi bi-geo-alt"></i> {{ __('Destinasi') }}
    </a>
    <a class="sidebar-item {{ request()->routeIs('admin.destination-categories.*') ? 'active' : '' }}" href="{{ route('admin.destination-categories.index') }}">
        <i class="bi bi-tags"></i> {{ __('Kategori Destinasi') }}
    </a>
</div>

<div class="sidebar-section">
    <div class="sidebar-section-title">{{ __('Pengaturan') }}</div>
    <a class="sidebar-item {{ request()->routeIs('admin.services.*') ? 'active' : '' }}" href="{{ route('admin.services.index') }}">
        <i class="bi bi-gear"></i> {{ __('Layanan') }}
    </a>
    <a class="sidebar-item {{ request()->routeIs('admin.banks.*') ? 'active' : '' }}" href="{{ route('admin.banks.index') }}">
        <i class="bi bi-bank"></i> {{ __('Rekening Bank') }}
    </a>
    <a class="sidebar-item {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}" href="{{ route('admin.testimonials.index') }}">
        <i class="bi bi-chat-quote"></i> {{ __('Testimoni') }}
    </a>
    <a class="sidebar-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}">
        <i class="bi bi-sliders"></i> {{ __('Kontak & Sosmed') }}
    </a>
    <a class="sidebar-item {{ request()->routeIs('admin.whatsapp.*') ? 'active' : '' }}" href="{{ route('admin.whatsapp.index') }}">
        <i class="bi bi-whatsapp"></i> {{ __('WhatsApp API') }}
    </a>
    <a class="sidebar-item {{ request()->routeIs('admin.email.*') ? 'active' : '' }}" href="{{ route('admin.email.index') }}">
        <i class="bi bi-envelope"></i> {{ __('Notifikasi Email') }}
    </a>
</div>

<div class="sidebar-divider"></div>

<div class="sidebar-section">
    <a class="sidebar-item d-lg-none" href="#" onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">
        <i class="bi bi-box-arrow-right"></i> {{ __('Logout') }}
    </a>
    <form id="logout-form-mobile" action="{{ route('admin.logout') }}" method="POST" class="d-none">@csrf</form>
</div>
