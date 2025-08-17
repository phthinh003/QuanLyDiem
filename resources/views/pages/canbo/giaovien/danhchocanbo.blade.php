@extends('layouts.canbo.layoutcanbo')
@section('styles')
    <style>
        textarea.form-control {
            height: auto !important;
            min-height: 0;
            resize: vertical;
        }
    </style>
@endsection

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
                                <a
                                    href="{{ route('canboManage.danhsachlopchunhiem', ['malop' => $value->malop, 'hocky' => 1]) }}">Xem
                                    chi tiết</a>
                            </p>
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
        <div class="card shadow mb-4">
            <div class="card-header bg-light">📢 Thông báo</div>
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
        <!-- Form gửi thông báo -->
        <div class="card shadow mb-4">
            <div class="card-header bg-info text-white">📨 Gửi thông báo tới học sinh</div>
            <div class="card-body">
                <form action="{{ route('thongbao.store') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="loainguoigui" value="giaovien" />
                    <input type="hidden" name="loainguoinhan" value="hocsinh" />
                    <input type="hidden" name="nguoigui" value="{{ session('userid') }}" />
                    <div class="mb-3">
                        <label for="nguoinhan" class="form-label">Chọn lớp</label>
                        <select name="nguoinhan" id="nguoinhan" class="form-control" required>
                            @foreach ($datalopchunhiem as $lop)
                                <option value="{{ $lop->malop }}">{{ $lop->tenlop }} (lớp chủ nhiệm)
                                    ({{ $lop->tennienkhoa }})</option>
                            @endforeach
                            @foreach ($datalopday as $lop)
                                <option value="{{ $lop->malop }}">{{ $lop->tenlop }} - {{ $lop->tenmon }}
                                    ({{ $lop->tennienkhoa }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tieude" class="form-label">Tiêu đề</label>
                        <input type="text" name="tieude" id="tieude" class="form-control" required />
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Nội dung thông báo</label>
                        <textarea name="noidung" id="noidung" class="form-control" rows="3" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Gửi thông báo</button>
                </form>
            </div>
        </div>

        <!-- Lịch dạy hôm nay -->
        <div class="card shadow mb-4">
            <div class="card-header bg-light">Các thông báo đã gửi</div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach ($mythongbao->take(3) as $tb)
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div>
                                📢 <strong>{{ $tb->tieude }}</strong> | tới
                                {{ $tb->tenlop }}
                                <br>
                                <small class="text-muted">{{ $tb->noidung }}</small>
                            </div>

                            {{-- Form xoá --}}
                            <a href="{{ route('thongbao.destroy', $tb->id) }}" id="delete"
                                    class="btn btn-sm btn-icon btn-danger" data-confirm-delete="true" title="xoá">
                                    <i class="la la-trash"></i>Xoá
                                </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#loadMoreBtn").on("click", function() {
                let page = $(this).data("page");
                let loainguoinhan = 'giaovien';

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
