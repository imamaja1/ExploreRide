<ul class="nav flex-column pt-2">
    <li class="nav-item"><a class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> {{ __('Dashboard') }}</a></li>
    <li class="nav-item"><a class="{{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}" href="{{ route('admin.bookings.index') }}"><i class="bi bi-calendar-check"></i> {{ __('Pesanan') }}</a></li>
    <li class="nav-item"><a class="{{ request()->routeIs('admin.cars.*') ? 'active' : '' }}" href="{{ route('admin.cars.index') }}"><i class="bi bi-truck"></i> {{ __('Mobil') }}</a></li>
    <li class="nav-item"><a class="{{ request()->routeIs('admin.drivers.*') ? 'active' : '' }}" href="{{ route('admin.drivers.index') }}"><i class="bi bi-people"></i> {{ __('Driver') }}</a></li>
    <li class="nav-item"><a class="{{ request()->routeIs('admin.tour-packages.*') ? 'active' : '' }}" href="{{ route('admin.tour-packages.index') }}"><i class="bi bi-map"></i> {{ __('Paket Wisata') }}</a></li>
    <li class="nav-item"><a class="{{ request()->routeIs('admin.destinations.*') ? 'active' : '' }}" href="{{ route('admin.destinations.index') }}"><i class="bi bi-geo-alt"></i> {{ __('Destinasi') }}</a></li>
    <li class="nav-item"><a class="{{ request()->routeIs('admin.destination-categories.*') ? 'active' : '' }}" href="{{ route('admin.destination-categories.index') }}"><i class="bi bi-tags"></i> {{ __('Kategori Destinasi') }}</a></li>
    <li class="nav-item"><a class="{{ request()->routeIs('admin.services.*') ? 'active' : '' }}" href="{{ route('admin.services.index') }}"><i class="bi bi-gear"></i> {{ __('Layanan') }}</a></li>
    <li class="nav-item"><a class="{{ request()->routeIs('admin.banks.*') ? 'active' : '' }}" href="{{ route('admin.banks.index') }}"><i class="bi bi-bank"></i> {{ __('Bank') }}</a></li>
    <li class="nav-item"><a class="{{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}" href="{{ route('admin.testimonials.index') }}"><i class="bi bi-chat-quote"></i> {{ __('Testimoni') }}</a></li>
    <li class="nav-item mt-3 border-top border-light border-opacity-25 pt-3">
        <a class="" href="{{ route('home') }}" target="_blank"><i class="bi bi-box-arrow-up-right"></i> {{ __('Ke Website') }}</a>
    </li>
    <li class="nav-item d-lg-none">
        <a class="" href="#" onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();"><i class="bi bi-box-arrow-right"></i> {{ __('Logout') }}</a>
        <form id="logout-form-mobile" action="{{ route('admin.logout') }}" method="POST" class="d-none">@csrf</form>
    </li>
</ul>
