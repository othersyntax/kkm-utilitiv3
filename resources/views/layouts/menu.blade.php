<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
        <li class="nav-item ">
            <a href="/dashboard" class="nav-link {{ (request()->is('dashboard')) ? 'active' : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
            </a>
        </li>
        <li class="nav-item {{ (request()->segment(1) == 'pentadbir') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ (request()->segment(1) == 'utiliti') ? 'active' : '' }}">
            <i class="nav-icon fas fa-cogs"></i>
            <p>
                Pentadbiran
                <i class="fas fa-angle-left right"></i>
            </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="/pentadbir/fasiliti/senarai" class="nav-link {{ (request()->segment(2) == 'fasiliti') ? 'active' : '' }}">
                    <i class="fas fa-ambulance nav-icon"></i>
                    <p>Fasiliti</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/pentadbir/kategori/senarai" class="nav-link {{ (request()->segment(2) == 'kategori') ? 'active' : '' }}">
                    <i class="fas fa-list nav-icon"></i>
                    <p>Kategori Fasiliti</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/pentadbir/pengguna/senarai" class="nav-link {{ (request()->segment(2) == 'pengguna') ? 'active' : '' }}">
                    <i class="fas fa-users nav-icon"></i>
                    <p>Senarai Pengguna</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/pentadbir/data/senarai" class="nav-link {{ (request()->segment(2) == 'data') ? 'active' : '' }}">
                    <i class="fas fa-file-excel nav-icon"></i>
                    <p>Muatnaik Data</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="{{ route('logout1') }}" class="nav-link">
                <i class="nav-icon fas fa-times-circle"></i>
                <p>Logout</p>
            </a>
        </li>
    </ul>
</nav>