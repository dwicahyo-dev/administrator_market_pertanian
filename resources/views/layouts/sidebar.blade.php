<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('home') }}">Market Pertanian</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('home') }}">M-P</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ Helpers::setSelected('home') }}">
                <a href="{{ route('home') }}" class="nav-link ">
                    <i class="fas fa-fire"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            @role('superadministrator')

            <li class="menu-header">Data Master</li>
            <li class="{{ Helpers::setSelected('commodity') }}">
                <a href="{{ route('commodity.index') }}" class="nav-link ">
                    <i class="fas fa-tree"></i>
                    <span>Komoditas</span>
                </a>
            </li>

            <li class="{{ Helpers::setSelected('quality') }}">
                <a href="{{ route('quality.index') }}" class="nav-link ">
                    <i class="fas fa-balance-scale"></i>
                    <span>Kualitas</span>
                </a>
            </li>

            <li class="menu-header">Data Transaksi</li>
            <li class="{{ Helpers::setSelected('agriculture') }}">
                <a href="{{ route('agriculture.index') }}" class="nav-link ">
                    <i class="fas fa-cloud"></i>
                    <span>Hasil Pertanian</span>
                </a>
            </li>

            {{-- <li class="{{ Helpers::setSelected('quality_of_agriculture') }}">
            <a href="{{ route('quality_of_agriculture.index') }}" class="nav-link ">
                <i class="fas fa-star"></i>
                <span>Kualitas Hasil Pertanian</span>
            </a>
            </li> --}}

            <li class="{{ Helpers::setSelected('standard_price') }}">
                <a href="{{ route('standard_price.index') }}" class="nav-link ">
                    <i class="fas fa-money-check-alt"></i>
                    <span>Standar Harga</span>
                </a>
            </li>

            <li class="menu-header">Data Users</li>
            <li class="{{ Helpers::setSelected('users') }}">
                <a href="{{ route('users.index') }}" class="nav-link ">
                    <i class="fas fa-users"></i>
                    <span>Users</span>
                </a>
            </li>

            <li class="{{ Helpers::setSelected('users_role') }}">
                <a href="{{ route('users_role.index') }}" class="nav-link ">
                    <i class="fas fa-users-cog"></i>
                    <span>Users Role</span>
                </a>
            </li>

            @else

            <li class="menu-header">Data Transaksi</li>
            <li class="{{ Helpers::setSelected('agriculture') }}">
                <a href="{{ route('agriculture.index') }}" class="nav-link ">
                    <i class="fas fa-cloud"></i>
                    <span>Hasil Pertanian</span>
                </a>
            </li>

            {{-- <li class="{{ Helpers::setSelected('quality_of_agriculture') }}">
            <a href="{{ route('quality_of_agriculture.index') }}" class="nav-link ">
                <i class="fas fa-star"></i>
                <span>Kualitas Hasil Pertanian</span>
            </a>
            </li> --}}

            <li class="{{ Helpers::setSelected('standard_price') }}">
                <a href="{{ route('standard_price.index') }}" class="nav-link ">
                    <i class="fas fa-money-check-alt"></i>
                    <span>Standar Harga</span>
                </a>
            </li>

            @endrole

        </ul>
    </aside>
</div>