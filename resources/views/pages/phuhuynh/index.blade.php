@extends('layouts.phuhuynh.layoutphuhuynh')
@section('content')
<div class="container py-4">

    <h2 class="mb-4">👨‍👩‍👧 Xin chào – {{ $phuhuynh->tenphuhuynh }}</h2>

    <!-- Học sinh -->
    @foreach ($datalop as $item => $value)
        <div class="card shadow mb-4">
            <div class="card-header bg-{{ $value->xong==true?'success':'primary' }} text-white">👧 Con: {{ $value->hotenhocsinh }} –
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
                    <ul class="list-group list-group-flush" id="listThongBao">
                            @foreach ($thongbao->take(3) as $tb)
                                <li class="list-group-item">
                                    📢 <strong>{{ $tb->tieude }} </strong> | từ
                                    @if ($tb->loainguoigui == 'bangiamhieu')
                                        <span class="fw-normal text-muted">Ban giám hiệu</span>
                                    @elseif ($tb->loainguoigui == 'hethong')
                                        <span class="fw-normal text-muted">Hệ thống</span>
                                    @endif
                                    <br>
                                    <small class="text-muted">{{ $tb->noidung }}</small>
                                </li>
                            @endforeach
                        </ul>

                        {{-- Nút xem thêm --}}
                        <div class="text-center mt-2">
                            <button id="loadMoreBtn" class="btn btn-sm btn-outline-primary" data-page="2">
                                Xem thêm
                            </button>
                        </div>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                $("#loadMoreBtn").on("click", function() {
                    let page = $(this).data("page");
                    let loainguoinhan = 'phuhuynh';

                    $.ajax({
                        url: "{{ route('thongbao.load', ['page' => 'PAGE', 'loainguoinhan' => 'TYPE']) }}"
                            .replace('PAGE', page)
                            .replace('TYPE', loainguoinhan),
                        type: "GET",
                        success: function(res) {
                            if (res.length > 0) {
                                res.forEach(function(tb) {
                                    $("#listThongBao").append(
                                        `<li class="list-group-item">
                                📢 <strong>${tb.tieude}</strong><br>
                                <small class="text-muted">${tb.noidung}</small>
                             </li>`
                                    );
                                });
                                $("#loadMoreBtn").data("page", page + 1);
                            } else {
                                $("#loadMoreBtn").text("Hết thông báo").prop("disabled", true);
                            }
                        }
                    });
                });
            });
        </script>
@endsection
