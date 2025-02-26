<ul class="list-unstyled components mb-5">
    <li class="{{ request()->is('*phuhuynh') ? 'active' : '' }}">
        <a href="{{ route('phuhuynhManage.indexPhuHuynhPage') }}">Bảng điều khiển</a>
    </li>
    {{-- <li class="{{ request()->is('*phuhuynh*') ? 'active' : '' }}">
        <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Lớp học</a>
        <ul class="collapse list-unstyled" id="homeSubmenu">
            @foreach ($datalop as $lop)
                <li>
                    <a href="{{ route('hocsinhManage.diemhocsinh', ['malop' => $lop->malop, 'hocki' => 1]) }}">
                        {{ $lop->tenlop }}
                    </a>
                </li>
            @endforeach

        </ul>
    </li> --}}
    @foreach ($menu as $item => $v)
        @foreach ($v as $k => $value)
            @if ($k == 'hocsinh')
                <li>
                    <a href="#{{ $value->mahocsinh }}" data-toggle="collapse" aria-expanded="false"
                        class="dropdown-toggle">{{ $value->hotenhocsinh }}</a>
                    <ul class="collapse list-unstyled" id="{{ $value->mahocsinh }}">
                    @else
                        @foreach ($value as $lopcol)
                            @foreach ($lopcol as $lop)
                                <li>

                                    <a href="{{ route('phuhuynhManage.diemhocsinhPH', ['mahocsinh'=>$lop->mahocsinh,'malop' => $lop->malop, 'hocki' => 1]) }}">
                                        {{ $lop->tenlop }}
                                    </a>
                                </li>
                            @endforeach
                        @endforeach

                    </ul>
                </li>
            @endif
        @endforeach
    @endforeach

    {{-- <li>
        <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false"
            class="dropdown-toggle">Các lớp đang dạy</a>
        <ul class="collapse list-unstyled" id="pageSubmenu"> --}}
    {{-- @foreach ($datalopday as $lopday)
            <li>
                <a href="{{ route('canboManage.danhsachlopday', ['mamonhoc' => $lopday->mamonhoc]) }}">{{ $lopday->tenlop }} - {{ $lopday->tenmon }}</a>
            </li>
            @endforeach --}}

    {{-- </ul>
    </li> --}}
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
    <li>
        <a href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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
