<section id="body-pd" class="bg-light">
    <header class="header" id="header">
        <div class="header_toggle">
            <i class='bx bx-menu' id="header-toggle"></i>
        </div>
        <div class="d-flex align-items-center">
            <div class="header_img">
                {{-- <img src="{{ asset('images/logo1000.png') }}" alt="No image"> --}}
            </div>
            <div class="w-auto d-flex align-items-center btn-lg px-2">
                <span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">Xin chào</span>
                <span
                    class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3">&nbsp;{{ session()->get('userhoten') }}</span>
            </div>
        </div>

    </header>
    <div class="l-navbar" id="nav-bar">
        <nav class="nav">
            <div>
                <a href="/dashboard" class="nav_logo">
                    <i class='bx bx-layer nav_logo-icon'></i>
                    {{-- <div style="border-radius: 10px; background-color: white; width: 50px;">
                        <img style="width: 100%; border-radius: 10px; padding: 5px 7px 5px 5px" src="{{ asset('images/logo.png') }}"
                            alt="No image" />
                    </div> --}}
                    {{-- <span class="nav_logo-name">THPT Tây Đô</span> --}}
                </a>
                <div class="nav_list">

                    <a title="" id="dashboard" href="{{ route('dashboard') }}"
                        class="nav_link {{ request()->is('dashboard*') ? 'active' : '' }}">
                        <i class='bx bx-grid-alt nav_icon'></i>
                        <span class="nav_name">Dashboard</span>
                    </a>

                    <a title="Cán bộ" id="canbo" href="{{ route('canboManage.indexCanbo') }}"
                        class="nav_link {{ request()->is('canbo*') ? 'active' : '' }}">
                        <i class='bx bx-user nav_icon'></i>
                        <span class="nav_name">Cán bộ</span>
                    </a>
                    <a title="Học sinh" id="hocsinh" href="{{ route('hocsinhManage.index') }}"
                        class="nav_link {{ request()->is('hocsinh*') ? 'active' : '' }}">
                        <i class='bx bx-user nav_icon'></i>
                        <span class="nav_name">Học sinh</span>
                    </a>
                    <a title="Phụ huynh" id="phuhuynh" href="{{ route('phuhuynhManage.index') }}"
                        class="nav_link {{ request()->is('phuhuynh*') ? 'active' : '' }}">
                        <i class='bx bx-user nav_icon'></i>
                        <span class="nav_name">Phụ huynh</span>
                    </a>
                    <a title="Môn" id="mon" href="{{ route('monManage.indexMon') }}"
                        class="nav_link {{ request()->is('mon*') ? 'active' : '' }}">
                        <i class='bx bx-bookmark nav_icon'></i>
                        <span class="nav_name">Môn</span>
                    </a>
                    <a title="Niên khoá" id="nienkhoa" href="{{ route('nienkhoaManage.indexNienKhoa') }}"
                        class="nav_link {{ request()->is('nienkhoa*') ? 'active' : '' }}">
                        <i class='bx bx-calendar nav_icon'></i>
                        <span class="nav_name">Niên Khóa</span>
                    </a>
                    <a title="Lớp" id="lop" href="{{ route('lopManage.indexLop') }}"
                        class="nav_link {{ request()->is('lop*') ? 'active' : '' }}">
                        <i class='bx bx-calendar nav_icon'></i>
                        <span class="nav_name">Lớp</span>
                    </a>
                    <a title="Phân công giảng dạy" id="monhoc" href="{{ route('monhocManage.indexMonHoc') }}"
                        class="nav_link {{ request()->is('phan-giang*') ? 'active' : '' }}">
                        <i class='bx bx-message-square-detail nav_icon'></i>
                        <span class="nav_name">Phân công giảng dạy</span>
                    </a>
                    <a title="Loại điểm" id="loaidiem" href="{{ route('loaidiemManage.indexLoaiDiem') }}"
                        class="nav_link {{ request()->is('loaidiem*') ? 'active' : '' }}">
                        <i class='bx bx-bookmark nav_icon'></i>
                        <span class="nav_name">Loại Điểm</span>
                    </a>
                </div>
            </div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
            <a href="{{ route('logout') }}" class="nav_link"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class='bx bx-log-out nav_icon'></i>
                <span class="nav_name">Đăng xuất</span>
            </a>
        </nav>
    </div>
</section>
<script src="{{ asset('js/menu.js') }}"></script>
