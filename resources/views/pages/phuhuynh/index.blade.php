@extends('layouts.phuhuynh.layoutphuhuynh')
@section('content')
<div class="container py-4">

    <h2 class="mb-4">👨‍👩‍👧 Xin chào – {{ $phuhuynh->tenphuhuynh }}</h2>
    <div class="row">
        <!-- Thông báo -->
        <div class="col-md-12">
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
                        class="btn btn-light btn-sm">🔍 Xem lớp học</a>
                </div>
            </div>
        </div>
    @endforeach


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
