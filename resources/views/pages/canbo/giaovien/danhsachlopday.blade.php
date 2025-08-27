@extends('layouts.canbo.layoutcanbo')
@section('styles')
    <style>
        /* Chrome */
        .diem-input::-webkit-inner-spin-button,
        .diem-input::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        .diem-input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
@endsection
@section('content')
    <div class="mt-2 pt-2 card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="cart-title">
                <input type="hidden" name="filename" value="{{ $filename }}">
                {{-- @foreach ($thongtinlop as $key => $value)
                    {{ $key }} : {{ $value }}<br />
                @endforeach --}}
                {{-- {{ dd() }} --}}
                <b>Tên cán bộ</b> : {{ $thongtinlop['canbo'] }} <br />
                <b>Môn</b> : {{ $thongtinlop['mon'] }} <br />
                <b>Tên lớp</b> : {{ $thongtinlop['tenlop'] }} <br />
                <b>Sỉ số</b> : {{ $thongtinlop['siso'] }} <br />
                <b>Năm học</b> : {{ $thongtinlop['nienkhoa'] }} <br />
            </div>
            <hr>
            <div class="card-toolbar">
                <a href="{{ route('canboManage.danhsachlopday', ['mamonhoc' => $mamonhoc, 'hocky' => 1]) }}">
                    <button class="btn {{ request()->is('*1') ? 'btn-success' : '' }}">Học Kì 1</button></a>
                <a href="{{ route('canboManage.danhsachlopday', ['mamonhoc' => $mamonhoc, 'hocky' => 2]) }}">
                    <button class="btn {{ request()->is('*2') ? 'btn-success' : '' }}">Học Kì 2</button></a>
                <a href="{{ route('canboManage.bangdiemcanamlopday', ['mamonhoc' => $mamonhoc]) }}">
                    <button class="btn {{ request()->is('*3') ? 'btn-success' : '' }}">Cả Năm</button></a>
                <a href="{{ route('canboManage.excelExport', [$mamonhoc, $thongtinlop['malop'], $hocki]) }}">
                    <button class="btn">Excel</button></a>
            </div>
        </div>
        {{-- {{ dd($mamonhoc) }} --}}
        <div class="card-body">
            <div class="table-responsive">
                <table style="width: 100%; " class="table table-bordered table-hover table-checkable" id="danhSachDiem">
                    <thead class="thead-light">
                        <tr>
                            <th rowspan="{{ $hocki < 3 ? 2 : 1 }}" class="text-center">STT</th>
                            <th rowspan="{{ $hocki < 3 ? 2 : 1 }}" class="text-center">Mã Học Sinh</th>
                            <th rowspan="{{ $hocki < 3 ? 2 : 1 }}" class="text-center">Họ Tên Học Sinh</th>
                            @foreach ($dataloaidiem as $item => $loaidiem)
                                <th colspan="{{ $hocki < 3 ? $loaidiem->soluong : 1 }}" class="text-center diem"
                                    data-dt-order="disable">
                                    {{ $loaidiem->tenloaidiem }}
                                    <?php $lankt[] = $loaidiem->soluong; ?>
                                </th>
                            @endforeach
                            @if ($hocki < 3)
                                <th rowspan="2" class="text-center diem">TBM</th>

                                @if ($khoadiem == false)
                                    <th rowspan="2" class="text-center noExport">Thao tác</th>
                                @endif
                            @endif
                        </tr>
                        @if ($hocki < 3)
                            <tr>
                                @foreach ($lankt as $value)
                                    @for ($i = 1; $i <= $value; $i++)
                                        <th data-dt-order="disable" class="text-center">L{{ $i }}</th>
                                    @endfor
                                @endforeach
                            </tr>
                        @endif
                    </thead>

                    <tbody>
                        @foreach ($danhsach as $item => $value)
                            <tr>

                                <td class="text-center font-weight-bold">{{ $item + 1 }}</td>
                                @foreach ($value as $key => $v)
                                    @if ($key == 'mahocsinh')
                                        <td class="text-center">{{ $v }}</td>
                                    @elseif ($key == 'tenhocsinh')
                                        <td class="text-center">{{ $v }}</td>
                                    @elseif ($key == 'tbm')
                                        <td class="text-center diem" id="tbm_{{ $value['mahocsinh'] }}">
                                            {{ $v }}
                                        </td>
                                    @elseif($key == 'diem')
                                        @foreach ($v as $keydiem => $diem)
                                            <td data-id="{{ $keydiem }}" data-field="diem" data-value="{{ $diem }}"
                                                class="text-center editable">
                                                {{-- <input style="border: 0" class="form-control form-control-sm diem-input"
                                                    min="0" max="10" step="0.25" type="number"
                                                    value="{{ $diem != '' ? number_format((float) $diem, 2, '.', '') : '' }}"> --}}
                                                @if ($thongtinlop['kieudiem'] == 0)
                                                    {{ $diem }}
                                                @else
                                                    {{-- {{  dd($diem) }} --}}
                                                    @if ($hocki == 3)
                                                        {{ $diem }}
                                                    @endif
                                                    @switch($diem)
                                                        @case('d')
                                                            Đạt
                                                            @break
                                                        @case('cd')
                                                            Chưa đạt
                                                        @break
                                                        @default

                                                    @endswitch
                                                @endif
                                            </td>
                                        @endforeach
                                    @endif
                                @endforeach
                                {{-- Cột thao tác --}}
                                @if ($hocki < 3)
                                    @if ($khoadiem == false)
                                        <td class="text-center">
                                            <a href="{{ route('diemManage.edit', ['hocki' => $hocki, 'mamonhoc' => $mamonhoc, 'mahocsinh' => $value['mahocsinh']]) }}"
                                                class="btn btn-primary" title="Chỉnh sửa">Chỉnh sửa</a>
                                        </td>
                                    @endif
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!--end: Datatable-->
            </div>
        </div>
    </div>
@endsection
@section('styles')
    {{-- <link rel="stylesheet" href="{{ asset('css/crud/datatables/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.bundle.css') }}"> --}}
@endsection
@section('scripts')
    <script src="{{ asset('js/crud/lopday_datatables.js') }}"></script>

    {{-- Test --}}
    <script>
        @if ($khoadiem == true ? false : true)
            document.querySelectorAll('.editable').forEach(cell => {
                let oldValue = cell.innerText.trim();

                cell.addEventListener('dblclick', () => {
                    @if ($thongtinlop['kieudiem'] == 0)
                        if (cell.querySelector('input')) return; // đã có input thì không làm gì

                        oldValue = cell.innerText.trim();
                        const input = document.createElement('input');
                        input.type = 'number';
                        input.step = '0.01';
                        input.min = '0';
                        input.max = '10';
                        input.value = oldValue;
                        input.style.width = '100%';
                        input.style.boxSizing = 'border-box';
                        input.className = 'form-control';

                        cell.innerText = '';
                        cell.appendChild(input);
                        input.focus();
                        input.select();

                        const id = cell.dataset.id;
                        const sodiem = cell.dataset.field;

                        input.addEventListener('blur', () => {
                            // Kiểm tra thay đổi giá trị
                            const newValue = input.value.trim();
                            if (parseFloat(oldValue) == parseFloat(newValue) || oldValue ==
                                newValue) {
                                cell.innerText = oldValue;
                                return;
                            }

                            // Kiểm tra min max
                            if (isNaN(newValue) || newValue < 0 || newValue > 10) {
                                alert("Điểm phải nằm trong khoảng từ 0 đến 10");
                                cell.innerText = oldValue;
                                input.focus();
                                return;
                            }

                            fetch(`/diem-ajax/${id}`, {
                                    method: 'PUT',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({
                                        [sodiem]: newValue,
                                        "mamonhoc": {{ $mamonhoc }},
                                        "hocki": {{ $hocki }}
                                    })
                                })
                                .then(res => res.json())
                                .then(data => {
                                    if (data.success) {
                                        cell.innerText = data.diem_moi;
                                        cell.setAttribute("data-id", data.madiem_moi);
                                        document.getElementById("tbm_" + data.mahocsinh)
                                            .innerText =
                                            data.tbm;
                                        cell.style.background = 'lightgreen';
                                        setTimeout(() => cell.style.background = '', 3000);
                                    } else {
                                        cell.innerText = oldValue;
                                        alert('Lưu thất bại!');
                                    }
                                })
                                .catch(() => {
                                    cell.innerText = oldValue;
                                    alert('Lỗi mạng hoặc server!');
                                });
                        });

                        input.addEventListener('keydown', e => {
                            if (e.key === 'Enter') {
                                e.preventDefault();
                                input.blur(); // gọi blur để trigger lưu
                            } else if (e.key === 'Escape') {
                                cell.innerText = oldValue; // hủy bỏ chỉnh sửa
                            }
                        });

                        // Kiểm tra khi đang nhập
                        input.addEventListener('input', () => {
                            const val = input.value;
                            if (!/^(10(\.0{1,2})?|[0-9](\.\d{1,2})?)$/.test(val)) {
                                input.value = val.slice(0, -1); // chặn nhập sai
                            }
                        });
                    @else
                        // Nếu đã có select thì không tạo lại
                        if (cell.querySelector("select")) return;

                        // Giá trị hiện tại trong ô
                        let oldValue = cell.getAttribute("data-value") || "";
                        let oldText = cell.innerText;

                        // Tạo select
                        let select = document.createElement("select");
                        select.name = "diem";
                        select.className = 'form-control';
                        select.width = '100%';

                        // Các option
                        let options = [{
                                value: "",
                                text: "Chọn"
                            },
                            {
                                value: "cd",
                                text: "Chưa đạt"
                            },
                            {
                                value: "d",
                                text: "Đạt"
                            }
                        ];

                        options.forEach(opt => {
                            let option = document.createElement("option");
                            option.value = opt.value;
                            option.textContent = opt.text;
                            if (opt.value === oldValue) option.selected = true;
                            select.appendChild(option);
                        });

                        // Xóa nội dung cũ và add select vào
                        cell.innerHTML = "";
                        cell.appendChild(select);
                        select.focus();

                        // Lấy mã học sinh
                        const id = cell.dataset.id;
                        const sodiem = cell.dataset.field;

                        select.addEventListener("blur", function() {
                            let newValue = select.value;
                            let text = select.options[select.selectedIndex].text;

                            // Không thực hiện thay đổi
                            if (oldValue == newValue) {
                                cell.innerText = oldValue;
                                return;
                            }

                            let tendiem = {null:'', 'cd':'Chưa đạt', 'd':'Đạt'};
                            // cell.innerHTML = text;

                            fetch(`/diem-ajax/${id}`, {
                                    method: 'PUT',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({
                                        [sodiem]: newValue,
                                        "mamonhoc": {{ $mamonhoc }},
                                        "hocki": {{ $hocki }}
                                    })
                                })
                                .then(res => res.json())
                                .then(data => {
                                    if (data.success) {
                                        cell.innerText = tendiem[data.diem_moi];
                                        cell.setAttribute("data-id", data.madiem_moi);
                                        cell.setAttribute("data-value", data.diem_moi);
                                        document.getElementById("tbm_" + data.mahocsinh)
                                            .innerText =
                                            data.tbm;
                                        cell.style.background = 'lightgreen';
                                        setTimeout(() => cell.style.background = '', 3000);
                                    } else {
                                        cell.innerText = oldValue;
                                        alert('Lưu thất bại!');
                                    }
                                })
                                .catch(() => {
                                    cell.innerText = oldValue;
                                    alert('Lỗi mạng hoặc server!');
                                });
                        });
                    @endif
                });
            });
        @endif
    </script>
@endsection
