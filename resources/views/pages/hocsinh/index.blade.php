@extends('layouts.hocsinh.layouthocsinh')
@section('content')
    <div class="container py-4">
        <!-- Thông tin học sinh -->
        <div class="d-flex align-items-center mb-4">
            {{-- <img src="https://via.placeholder.com/80" alt="Avatar" class="avatar me-3"> --}}
            <div>
                <h4 class="mb-1">👨‍🎓 {{ $hocsinh->hotenhocsinh }}</h4>
                <p class="mb-0">
                    @if($hocsinh->lophientai!=null)
                    Lớp: {{ $hocsinh->lophientai }} |
                    @endif
                    Mã HS: {{ $hocsinh->mahocsinh  }}
                    @if($hocsinh->nkhientai!=null)
                    | {{ $hocsinh->nkhientai }}
                    @endif

                </p>
            </div>
        </div>
        <h4 class="mb-3">📚 Các lớp học</h4>

        <div class="row row-cols-1 row-cols-md-3 g-4 mb-4">

            @foreach ($datalop as $item => $value)
                <div class="col">
                    <div class="card h-100 border-{{ $value->xong==true?'success':'primary' }} shadow">
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="{{ route('hocsinhManage.diemhocsinh', ['malop' => $value->malop, 'hocki' => 1]) }}"
                                    class="text-decoration-none text-{{ $value->xong==true?'success':'primary' }}">
                                    {{ $value->tenlop }}
                                </a>
                            </h5>
                            <p>Giáo viên: {{ $value->hoten }}</p>
                            <p>{{ $value->tennienkhoa }}</p>
                            <a href="{{ route('hocsinhManage.diemhocsinh', ['malop' => $value->malop, 'hocki' => 1]) }}"
                                class="btn btn-sm btn-outline-{{ $value->xong==true?'success':'primary' }}">Vào lớp</a>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Lớp khác tương tự -->
        </div>
        <!-- Lịch học hôm nay -->
        {{-- <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">🗓️ Lịch học hôm nay - Thứ 2</div>
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item">Tiết 1: Ngữ Văn - Cô Trinh (Phòng A1)</li>
                    <li class="list-group-item">Tiết 2: Toán - Thầy Bình (Phòng B3)</li>
                    <li class="list-group-item">Tiết 4: Lịch sử - Thầy Tài (Phòng C2)</li>
                </ul>
            </div>
        </div> --}}

        <!-- Bảng điểm -->
        {{-- <div class="card shadow mb-4">
            <div class="card-header bg-success text-white">📊 Kết quả học tập - Học kỳ I</div>
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
                            <td>8.5</td>
                            <td>9.0</td>
                            <td>8.75</td>
                        </tr>
                        <tr>
                            <td>Văn</td>
                            <td>7.0</td>
                            <td>7.5</td>
                            <td>7.25</td>
                        </tr>
                        <tr>
                            <td>Tiếng Anh</td>
                            <td>8.0</td>
                            <td>8.5</td>
                            <td>8.25</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div> --}}

        <!-- Thông báo -->
        <div class="row">
            <div class="col-md-6">
                <div class="card shadow mb-4">
                    <div class="card-header bg-warning">📢 Thông báo mới</div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Lịch thi HK1 bắt đầu từ 28/07</li>
                            <li class="list-group-item">Nộp bài tập Ngữ Văn trước 20/07</li>
                            <li class="list-group-item">Nghỉ học ngày 21/07 do bảo trì trường</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Công việc cần làm -->
            <div class="col-md-6">
                <div class="card shadow mb-4">
                    <div class="card-header bg-light">📝 Việc cần làm</div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">BTVN Toán – Trang 55</li>
                            <li class="list-group-item">Ôn tập Anh Văn Unit 7-8</li>
                            <li class="list-group-item">Soạn bài “Tuyên ngôn Độc lập”</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Shortcut -->
        <div class="text-center mt-4">
            <a href="#" class="btn btn-outline-primary me-2">📅 Thời khóa biểu</a>
            <a href="#" class="btn btn-outline-success me-2">📊 Xem điểm</a>
            <a href="#" class="btn btn-outline-secondary">📨 Gửi câu hỏi cho GV</a>
        </div>

    </div>
@endsection
