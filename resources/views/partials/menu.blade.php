<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">

        <a href="{{ route('home.index') }}" class="app-brand-link">
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
        @role('administrator')
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Users Management</span>
            </li>

            <li class="menu-item {{ request()->is('users*') ? 'open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div data-i18n="Kelola Pengguna">Kelola Pengguna</div>
                </a>

                <ul class="menu-sub">
                    <li class="menu-item {{ request()->is('backend/siswa*') ? 'active' : '' }}">
                        <a href="{{ route('backend.siswa.index') }}" class="menu-link">
                            <div data-i18n="Siswa">Kelola Siswa</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->is('backend/pembimbing*') ? 'active' : '' }}">
                        <a href="{{ route('backend.pembimbing.index') }}" class="menu-link">
                            <div data-i18n="Pembimbing">Kelola Pembimbing</div>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Master Data</span>
            </li>

            <li class="menu-item {{ request()->is('backend/jurusan*') ? 'active' : '' }}">
                <a href="{{ route('backend.jurusan.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-building"></i>
                    <div data-i18n="Jurusan">Kelola Jurusan</div>
                </a>
            </li>

            <li class="menu-item {{ request()->is('backend/dudi*') ? 'active' : '' }}">
                <a href="{{ route('backend.dudi.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-briefcase"></i>
                    <div data-i18n="DUDI">Kelola DUDI</div>
                </a>
            </li>

            <li class="menu-item {{ request()->is('backend/kuota_dudi*') ? 'active' : '' }}">
                <a href="{{ route('backend.kuota_dudi.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-list-ol"></i>
                    <div data-i18n="Kuota">Kuota DUDI</div>
                </a>
            </li>

            <li class="menu-item {{ request()->is('backend/tahun_pelaksanaan*') ? 'active' : '' }}">
                <a href="{{ route('backend.tahun_pelaksanaan.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-calendar"></i>
                    <div data-i18n="Tahun">Tahun Pelaksanaan</div>
                </a>
            </li>

            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Magang Management</span>
            </li>

            <li class="menu-item {{ request()->is('backend/pengajuan_magang*') ? 'active' : '' }}">
                <a href="{{ route('backend.pengajuan_magang.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-file-plus"></i>
                    <div data-i18n="Pengajuan">Pengajuan Magang</div>
                </a>
            </li>

            <li class="menu-item {{ request()->is('backend/lihat_pengajuan*') ? 'active' : '' }}">
                <a href="{{ route('backend.lihat_pengajuan') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-list-check"></i>
                    <div data-i18n="Lihat Pengajuan">Lihat Pengajuan Magang</div>
                </a>
            </li>

            <li class="menu-item {{ request()->is('backend/capaian_kompetensi*') ? 'active' : '' }}">
                <a href="{{ route('backend.capaian_kompetensi.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-target-lock"></i>
                    <div data-i18n="Capaian">Capaian Kompetensi</div>
                </a>
            </li>

            <li class="menu-item {{ request()->is('backend/surat_pengantar*') ? 'active' : '' }}">
                <a href="{{ route('backend.surat_pengantar.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-envelope"></i>
                    <div data-i18n="Surat">Surat Pengantar</div>
                </a>
            </li>

            <li class="menu-item {{ request()->is('backend/atur_pembimbing*') ? 'active' : '' }}">
                <a href="{{ route('backend.atur_pembimbing.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user-check"></i>
                    <div data-i18n="Atur">Atur Pembimbing</div>
                </a>
            </li>

            <li class="menu-item {{ request()->is('backend/logbook*') ? 'active' : '' }}">
                <a href="{{ route('backend.logbook.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-book"></i>
                    <div data-i18n="Logbook">Logbook</div>
                </a>
            </li>

            <li class="menu-item {{ request()->is('backend/laporan*') ? 'active' : '' }}">
                <a href="{{ route('backend.laporan.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-upload"></i>
                    <div data-i18n="Laporan">Upload Laporan Magang</div>
                </a>
            </li>

            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">System Management</span>
            </li>

            <li class="menu-item {{ request()->is('users*') ? 'open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-cog"></i>
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

            <li class="menu-item {{ request()->is('backend/logbook*') ? 'active' : '' }}">
                <a href="{{ route('backend.logbook.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-book"></i>
                    <div data-i18n="Logbook">Logbook</div>
                </a>
            </li>

            <li class="menu-item {{ request()->is('backend/pengajuan_magang*') ? 'active' : '' }}">
                <a href="{{ route('backend.pengajuan_magang.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-file-plus"></i>
                    <div data-i18n="Pengajuan">Pengajuan Magang</div>
                </a>
            </li>

            <li class="menu-item {{ request()->is('backend/laporan*') ? 'active' : '' }}">
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

            <li class="menu-item {{ request()->is('backend/logbook*') ? 'active' : '' }}">
                <a href="{{ route('backend.logbook.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-book"></i>
                    <div data-i18n="Logbook">Logbook</div>
                </a>
            </li>

            <li class="menu-item {{ request()->is('backend/laporan*') ? 'active' : '' }}">
                <a href="{{ route('backend.laporan.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-file"></i>
                    <div data-i18n="Laporan">Laporan Magang</div>
                </a>
            </li>
        @endrole

    </ul>
</aside>
