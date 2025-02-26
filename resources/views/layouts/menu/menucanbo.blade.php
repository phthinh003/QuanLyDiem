<ul class="list-unstyled components mb-5">
    <li class="{{ request()->is('*canbo') ? 'active' : '' }}">
        <a href="{{ route('canboManage.indexCanboPage') }}">Bảng điều khiển</a>
    </li>
    <li class="{{ request()->is('*danhsachlopchunhiem*') ? 'active' : '' }}">
        <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false"
            class="dropdown-toggle">Lớp đang chủ nhiệm</a>
        <ul class="collapse list-unstyled" id="homeSubmenu">
            @foreach ($datalopchunhiem as $lopchunhiem)
            <li>
                <a href="{{ route('canboManage.danhsachlopchunhiem', ['malop' => $lopchunhiem->malop,'hocky' => 1]) }}">{{ $lopchunhiem->tenlop }}</a>
            </li>
            @endforeach

        </ul>
    </li>

    <li class="{{ request()->is('*danhsachlopday*') ? 'active' : '' }}">
        <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false"
            class="dropdown-toggle">Các lớp đang dạy</a>
        <ul class="collapse list-unstyled" id="pageSubmenu">
            @foreach ($datalopday as $lopday)
            <li>
                <a href="{{ route('canboManage.danhsachlopday', ['mamonhoc' => $lopday->mamonhoc,'hocky' => 1]) }}">{{ $lopday->tenlop }} - {{ $lopday->tenmon }}</a>
            </li>
            @endforeach

        </ul>
    </li>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
    <li>
        <a href="{{ route('logout') }}"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Đăng xuất
        </a>
    </li>
    {{-- <li>
        <a href="#">Portfolio</a>
    </li>
    <li>
        <a href="#">Contact</a>
    </li> --}}
</ul>

{{-- <div class="mb-5">
    <h3 class="h6">Subscribe for newsletter</h3>
    <form action="#" class="colorlib-subscribe-form">
        <div class="form-group d-flex">
            <div class="icon"><span class="icon-paper-plane"></span></div>
            <input type="text" class="form-control" placeholder="Enter Email Address">
        </div>
    </form>
</div> --}}
