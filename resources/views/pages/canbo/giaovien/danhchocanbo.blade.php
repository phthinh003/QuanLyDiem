@extends('layouts.canbo.layoutcanbo')
@section('content')
    <div class="container py-4">
        <h2 class="mb-4">👨‍🏫 Trang chủ Giáo viên - Cán bộ {{ session('userhoten') }}</h2>

        <!-- Lớp chủ nhiệm -->
        @if (count($datalopchunhiem) != 0)
            <h4>Các lớp chủ nhiệm</h4>
            @foreach ($datalopchunhiem as $item => $value)
                <div class="card shadow mb-4">
                    <div class="card-header bg-primary text-white">
                        🏫 Lớp chủ nhiệm: {{ $value->tenlop }}
                    </div>

                    <div class="card-body row">
                        <div class="col-md-6">
                            <p><strong>Sĩ số:</strong> 42 học sinh</p>
                            <p><strong>Niên khóa:</strong> {{ $value->tennienkhoa }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Kết quả học kỳ:</strong>
                                <a href="{{ route('canboManage.danhsachlopchunhiem', ['malop' => $value->malop, 'hocky' => 1]) }}">Xem chi tiết</a></p>
                        </div>

                    </div>
                </div>
            @endforeach
            <hr>
        @endif
        <!-- Các lớp đang giảng dạy -->
        @if (count($datalopday) != 0)
            <h4 class="mb-3">📚 Các lớp đang giảng dạy</h4>
            <div class="row row-cols-1 row-cols-md-3 g-4 mb-4">
                @foreach ($datalopday as $item => $value)
                    <div class="col">
                        <div class="card h-100 border-success shadow">
                            <div class="card-body">
                                <h5 class="card-title">Tên lớp: {{ $value->tenlop }}</h5>
                                <p>Môn: {{ $value->tenmon }}</p>
                                <p>Niên khóa: {{ $value->tennienkhoa }}</p>
                                {{-- <p>Tiết kế tiếp: Thứ 3 - Tiết 2</p> --}}
                                <a href="{{ route('canboManage.danhsachlopday', ['mamonhoc' => $value->mamonhoc, 'hocky' => 1]) }}"
                                    class="btn btn-success btn-sm">Nhập điểm</a>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        <!-- Lịch dạy hôm nay -->
        <div class="card shadow mb-4">
            <div class="card-header bg-light">🗓️ Lịch dạy hôm nay (Thứ 2 - 17/07/2025)</div>
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item">Tiết 1: Lớp 10A2 - Môn Toán (Phòng A1)</li>
                    <li class="list-group-item">Tiết 3: Lớp 11B1 - Môn Toán (Phòng B2)</li>
                    <li class="list-group-item text-muted">Tiết 5: Trống</li>
                </ul>
            </div>
        </div>

        <!-- Nhắc việc + thông báo -->
        <div class="row">
            <div class="col-md-6">
                <div class="card shadow mb-4">
                    <div class="card-header bg-warning">📝 Công việc cần làm</div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Ghi điểm giữa kỳ lớp 10A2</li>
                            <li class="list-group-item">Duyệt đơn xin nghỉ của học sinh</li>
                            <li class="list-group-item">Chuẩn bị báo cáo GVCN</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow mb-4">
                    <div class="card-header bg-light">📢 Thông báo từ BGH</div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Lịch thi giữa kỳ bắt đầu từ 24/07</li>
                            <li class="list-group-item">Họp tổ Toán vào thứ 5 tuần này</li>
                            <li class="list-group-item">Nhắc nhở điểm danh đúng giờ</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
