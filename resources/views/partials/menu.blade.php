<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">

        <a href="{{ route('/') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                {{-- Logo Here --}}
            </span>
            <span class="app-brand-text demo menu-text fw-bold ms-2">SIPRAKERIN</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="align-middle bx bx-chevron-left bx-sm"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="py-1 menu-inner">

        {{-- Beranda untuk semua role --}}
        <li class="menu-item {{ request()->is('home') ? 'active' : '' }}">
            <a href="{{ route('home.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Beranda">Beranda</div>
            </a>
        </li>

        {{-- Menu untuk Administrator --}}
        @role('Administrator')
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Users Management</span>
            </li>

            <li class="menu-item {{ request()->is('users') ? 'open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-layout"></i>
                    <div data-i18n="Kelola Pengguna">Kelola Pengguna</div>
                </a>

                <ul class="menu-sub">
                    <li class="menu-item {{ request()->is('users') ? 'active' : '' }}">
                        <a href="{{ route('backend.siswa.index') }}" class="menu-link">
                            <div data-i18n="Pengguna">Kelola Siswa</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->is('users') ? 'active' : '' }}">
                        <a href="{{ route('backend.pembimbing.index') }}" class="menu-link">
                            <div data-i18n="Pengguna">Kelola Pembimbing</div>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="menu-item {{ request()->is('users') ? 'active' : '' }}">
                <a href="{{ route('backend.jurusan.index') }}" class="menu-link">
                    <div data-i18n="Pengguna">Kelola Jurusan</div>
                </a>
            </li>
            <li class="menu-item {{ request()->is('users') ? 'active' : '' }}">
                <a href="{{ route('backend.dudi.index') }}" class="menu-link">
                    <div data-i18n="Pengguna">Kelola DUDI</div>
                </a>
            </li>
            <li class="menu-item {{ request()->is('users') ? 'active' : '' }}">
                <a href="{{ route('backend.kuota_dudi.index') }}" class="menu-link">
                    <div data-i18n="Pengguna">Kuota DUDI</div>
                </a>
            </li>
            <li class="menu-item {{ request()->is('users') ? 'active' : '' }}">
                <a href="{{ route('backend.tahun_pelaksanaan.index') }}" class="menu-link">
                    <div data-i18n="Pengguna">Tahun Pelaksanaan</div>
                </a>
            </li>
            <li class="menu-item {{ request()->is('users') ? 'active' : '' }}">
                <a href="{{ route('backend.pengajuan_magang.index') }}" class="menu-link">
                    <div data-i18n="Pengguna">Pengajuan Magang</div>
                </a>
            </li>
            <li class="menu-item {{ request()->is('users') ? 'active' : '' }}">
                <a href="{{ route('backend.lihat_pengajuan') }}" class="menu-link">
                    <div data-i18n="Pengguna">Lihat Pengajuan Magang</div>
                </a>
            </li>
            <li class="menu-item {{ request()->is('users') ? 'active' : '' }}">
                <a href="{{ route('backend.capaian_kompetensi.index') }}" class="menu-link">
                    <div data-i18n="Pengguna">Capaian Kompetensi</div>
                </a>
            </li>
            <li class="menu-item {{ request()->is('users') ? 'active' : '' }}">
                <a href="{{ route('backend.surat_pengantar.index') }}" class="menu-link">
                    <div data-i18n="Pengguna">Surat Pengantar</div>
                </a>
            </li>
            <li class="menu-item {{ request()->is('users') ? 'active' : '' }}">
                <a href="{{ route('backend.atur_pembimbing.index') }}" class="menu-link">
                    <div data-i18n="Pengguna">Atur Pembimbing</div>
                </a>
            </li>
            <li class="menu-item {{ request()->is('users') ? 'active' : '' }}">
                <a href="{{ route('backend.logbook.index') }}" class="menu-link">
                    <div data-i18n="Pengguna">Logbook</div>
                </a>
            </li>
            <li class="menu-item {{ request()->is('users') ? 'active' : '' }}">
                <a href="{{ route('backend.laporan.index') }}" class="menu-link">
                    <div data-i18n="Pengguna">Upload Laporan Magang</div>
                </a>
            </li>

            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">System Management</span>
            </li>

            <li class="menu-item {{ request()->is('users') ? 'open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-layout"></i>
                    <div data-i18n="Pengaturan Sistem">Pengaturan Sistem</div>
                </a>

                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="" class="menu-link">
                            <div data-i18n="Pengaturan">Pengaturan</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endrole

        {{-- Menu untuk Siswa --}}
        @role('siswa')
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Menu Siswa</span>
            </li>

            <li class="menu-item {{ request()->is('logbook*') ? 'active' : '' }}">
                <a href="{{ route('backend.logbook.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-book"></i>
                    <div data-i18n="Logbook">Logbook</div>
                </a>
            </li>

            <li class="menu-item {{ request()->is('pengajuan*') ? 'active' : '' }}">
                <a href="{{ route('backend.pengajuan_magang.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-file"></i>
                    <div data-i18n="Pengajuan">Pengajuan Magang</div>
                </a>
            </li>

            <li class="menu-item {{ request()->is('laporan*') ? 'active' : '' }}">
                <a href="{{ route('backend.laporan.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-upload"></i>
                    <div data-i18n="Laporan">Upload Laporan Magang</div>
                </a>
            </li>
        @endrole

        {{-- Menu untuk Pembimbing --}}
        @role('pembimbing')
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Menu Pembimbing</span>
            </li>

            <li class="menu-item {{ request()->is('logbook*') ? 'active' : '' }}">
                <a href="{{ route('backend.logbook.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-book"></i>
                    <div data-i18n="Logbook">Logbook</div>
                </a>
            </li>

            <li class="menu-item {{ request()->is('laporan*') ? 'active' : '' }}">
                <a href="{{ route('backend.laporan.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-file"></i>
                    <div data-i18n="Laporan">Laporan Magang</div>
                </a>
            </li>
        @endrole

    </ul>
</aside>
