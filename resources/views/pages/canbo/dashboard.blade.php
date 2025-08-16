@extends('layouts.admin.layout')
@section('content')
    <style>
        .card-icon {
            font-size: 2.5rem;
            opacity: 1;
        }
    </style>
    <!--Container Main start-->
    <div class="container my-4">
        <h2 class="text-center mb-4">📊 Dashboard Quản lý Trường học</h2>

        <!-- Thống kê tổng quan -->
        <div class="row g-4 mb-4 text-center">
            <div class="col-md-3">
                <a href="{{ route('hocsinhManage.index') }}" class="card border-primary shadow h-100">
                    <div class="card-body">
                        <div class="card-icon">👨‍🎓</div>
                        <h5 class="card-title">Học sinh</h5>
                        <p class="display-6 fw-bold">{{ $slhocsinh }}</p>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ route('canboManage.indexCanbo') }}" class="card border-success shadow h-100">
                    <div class="card-body">
                        <div class="card-icon">👩‍🏫</div>
                        <h5 class="card-title">Giáo viên</h5>
                        <p class="display-6 fw-bold">{{ $slcanbo - 1 }}</p>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ route('phuhuynhManage.index') }}" class="card border-warning shadow h-100">
                    <div class="card-body">
                        <div class="card-icon">🧑‍🤝‍🧑</div>
                        <h5 class="card-title">Phụ huynh</h5>
                        <p class="display-6 fw-bold">{{ $slphuhuynh }}</p>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ route('lopManage.indexLop') }}" class="card border-info shadow h-100">
                    <div class="card-body">
                        <div class="card-icon">🏫</div>
                        <h5 class="card-title">Lớp học</h5>
                        <p class="display-6 fw-bold">{{ $sllop }}</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Biểu đồ + Thông báo -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-light">
                        📈 Biểu đồ tỉ lệ học sinh theo khối
                    </div>
                    <div class="card-body">
                        <canvas id="chart" height="100px"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow mb-3">
                    <div class="card-header bg-light">🔔 Thông báo nội bộ</div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @foreach ($thongbao as $tb)
                                <li class="list-group-item">
                                    📢 <strong>{{ $tb->tieude }}</strong> <br>
                                    <small class="text-muted">{{ $tb->noidung }}</small>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Shortcut -->
                <div class="d-grid gap-2">
                    <a class="btn btn-primary" href="{{ route('hocsinhManage.create') }}">➕ Thêm học sinh</a>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createNotificationModal">📄 Tạo
                        thông báo</button>
                </div>
            </div>
        </div>

        <!-- Modal tạo thông báo -->
        <div class="modal fade" id="createNotificationModal" tabindex="-1" aria-labelledby="createNotificationModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="createNotificationModalLabel">Tạo thông báo mới</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Đóng"></button>
                    </div>
                    <form action="{{ route('thongbao.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="loainguoigui" id="loainguoigui" class="form-control"
                                    value="bangiamhieu">
                            <input type="hidden" name="nguoigui" id="nguoigui" class="form-control"
                                    value="{{ session('userid') }}">
                            <!-- Tiêu đề -->
                            <div class="mb-3">
                                <label for="title" class="form-label fw-bold">Tiêu đề</label>
                                <input type="text" name="tieude" id="tieude" class="form-control"
                                    placeholder="Nhập tiêu đề thông báo" required>
                            </div>

                            <!-- Nội dung -->
                            <div class="mb-3">
                                <label for="content" class="form-label fw-bold">Nội dung</label>
                                <textarea name="noidung" id="noidung" class="form-control" rows="4" placeholder="Nhập nội dung thông báo"
                                    required></textarea>
                            </div>

                            <!-- Đối tượng nhận -->
                            <div class="mb-3">
                                <label for="target" class="form-label fw-bold">Gửi tới</label>
                                <select name="loainguoinhan" id="loainguoinhan" class="form-select" required>
                                    <option value="all">Tất cả</option>
                                    <option value="giaovien">Giáo viên</option>
                                    <option value="hocsinh">Học sinh</option>
                                    <option value="phuhuynh">Phụ huynh</option>
                                </select>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                            <button type="submit" class="btn btn-primary">Gửi thông báo</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>




        <!-- Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('chart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Khối 10', 'Khối 11', 'Khối 12'],
                    datasets: [{
                        label: 'Số lượng học sinh',
                        data: [{{ $k10 }}, {{ $k11 }}, {{ $k12 }}],
                        backgroundColor: ['#0d6efd', '#198754', '#ffc107']
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        </script>
        <!--Container Main end-->
    @endsection
