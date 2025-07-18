@extends('layouts.phuhuynh.layoutphuhuynh')
@section('content')
<div class="container py-4">

    <h2 class="mb-4">👨‍👩‍👧 Trang Phụ huynh – {{ $phuhuynh->tenphuhuynh }}</h2>

    <!-- Học sinh -->
    @foreach ($datalop as $item => $value)
        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">👧 Con: {{ $value->hotenhocsinh }} –
                <a href="{{ route('phuhuynhManage.diemhocsinhPH', [
                    'mahocsinh' => $value->mahocsinh,
                    'malop' => $value->malop,
                    'hocki' => 1,
                ]) }}"
                    class="text-white">{{ $value->tenlop }}</a>
            </div>
            <div class="card-body row align-items-center">
                <div class="col-md-4">
                    <p><strong>Năm học:</strong> {{ $value->tennienkhoa }}</p>
                    <p><strong>Giáo viên chủ nhiệm:</strong> {{ $value->hoten }}</p>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('phuhuynhManage.diemhocsinhPH', [
                        'mahocsinh' => $value->mahocsinh,
                        'malop' => $value->malop,
                        'hocki' => 1,
                    ]) }}"
                        class="btn btn-outline-light btn-sm">🔍 Xem lớp học</a>
                    <a href="#" class="btn btn-light btn-sm">📨 Gửi liên hệ GVCN</a>
                </div>
            </div>
        </div>
    @endforeach


    <!-- Bảng điểm -->
    <div class="card shadow mb-4">
        <div class="card-header bg-success text-white">📊 Kết quả học tập</div>
        <div class="card-body">
            <table class="table table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Môn</th>
                        <th>Giữa kỳ</th>
                        <th>Cuối kỳ</th>
                        <th>Trung bình</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Toán</td>
                        <td>8.0</td>
                        <td>9.0</td>
                        <td>8.5</td>
                    </tr>
                    <tr>
                        <td>Ngữ văn</td>
                        <td>7.0</td>
                        <td>7.5</td>
                        <td>7.25</td>
                    </tr>
                    <tr>
                        <td>Tiếng Anh</td>
                        <td>8.5</td>
                        <td>8.5</td>
                        <td>8.5</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Điểm danh -->
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header bg-info text-white">📅 Chuyên cần</div>
                <div class="card-body">
                    <p><strong>Số ngày đi học:</strong> 125</p>
                    <p><strong>Nghỉ có phép:</strong> 3</p>
                    <p><strong>Nghỉ không phép:</strong> 1</p>
                </div>
            </div>
        </div>

        <!-- Thông báo -->
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header bg-warning">📢 Thông báo mới</div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Họp phụ huynh ngày 25/07</li>
                        <li class="list-group-item">Báo cáo giữa kỳ đã cập nhật</li>
                        <li class="list-group-item">Thi HK1 bắt đầu từ 28/07</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Nút tiện ích -->
    <div class="text-center mt-4">
        <a href="#" class="btn btn-outline-primary me-2">📄 Xem phiếu điểm</a>
        <a href="#" class="btn btn-outline-secondary me-2">📅 Lịch học của con</a>
        <a href="#" class="btn btn-outline-success">📨 Gửi yêu cầu</a>
    </div>

</div>
@endsection
