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
      <div class="card border-primary shadow h-100">
        <div class="card-body">
          <div class="card-icon">👨‍🎓</div>
          <h5 class="card-title">Học sinh</h5>
          <p class="display-6 fw-bold">{{ $slhocsinh }}</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card border-success shadow h-100">
        <div class="card-body">
          <div class="card-icon">👩‍🏫</div>
          <h5 class="card-title">Giáo viên</h5>
          <p class="display-6 fw-bold">{{ $slcanbo }}</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card border-warning shadow h-100">
        <div class="card-body">
          <div class="card-icon">🧑‍🤝‍🧑</div>
          <h5 class="card-title">Phụ huynh</h5>
          <p class="display-6 fw-bold">{{ $slphuhuynh }}</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card border-info shadow h-100">
        <div class="card-body">
          <div class="card-icon">🏫</div>
          <h5 class="card-title">Lớp học</h5>
          <p class="display-6 fw-bold">15</p>
        </div>
      </div>
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
    <div class="col-md-4">
      <div class="card shadow mb-3">
        <div class="card-header bg-light">🔔 Thông báo nội bộ</div>
        <div class="card-body">
          <ul class="list-group list-group-flush">
            <li class="list-group-item">⏰ Ngày mai kiểm tra Toán</li>
            <li class="list-group-item">📅 Họp GVCN chiều thứ 5</li>
            <li class="list-group-item">📢 Cập nhật thông tin hồ sơ HS</li>
          </ul>
        </div>
      </div>

      <!-- Shortcut -->
      <div class="d-grid gap-2">
        <button class="btn btn-primary">➕ Thêm học sinh</button>
        <button class="btn btn-success">📄 Tạo thông báo</button>
      </div>
    </div>
  </div>

  <!-- Bảng danh sách -->
  <div class="card shadow">
    <div class="card-header bg-light">🧾 Học sinh mới nhập học</div>
    <div class="card-body p-0">
      <table class="table mb-0">
        <thead class="table-light">
          <tr>
            <th>STT</th>
            <th>Họ tên</th>
            <th>Lớp</th>
            <th>Ngày nhập học</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>Nguyễn Văn A</td>
            <td>10A1</td>
            <td>10/07/2025</td>
          </tr>
          <tr>
            <td>2</td>
            <td>Trần Thị B</td>
            <td>11A3</td>
            <td>10/07/2025</td>
          </tr>
          <tr>
            <td>3</td>
            <td>Lê Văn C</td>
            <td>12B2</td>
            <td>09/07/2025</td>
          </tr>
        </tbody>
      </table>
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
        label: 'Tỉ lệ học sinh',
        data: [{{ $a }}, {{ $b }}, {{ $c }}],
        backgroundColor: ['#0d6efd', '#198754', '#ffc107']
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { position: 'bottom' }
      }
    }
  });
</script>
    <!--Container Main end-->
@endsection
