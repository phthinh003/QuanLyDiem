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
                <b>Tên cán bộ</b> : {{ $thongtinlop['canbo'] }} <br/>
                <b>Môn</b> : {{ $thongtinlop['mon'] }} <br/>
                <b>Tên lớp</b> : {{ $thongtinlop['tenlop'] }} <br/>
                <b>Sỉ số</b> : {{ $thongtinlop['siso'] }} <br/>
                <b>Năm học</b> : {{ $thongtinlop['nienkhoa'] }}  <br/>
            </div>
            <hr>
            <div class="card-toolbar">
                <a href="{{ route('canboManage.danhsachlopday', ['mamonhoc' => $mamonhoc, 'hocky' => 1]) }}">
                    <button class="btn {{ request()->is('*1') ? 'btn-success' : '' }}">Học Kì 1</button></a>
                <a href="{{ route('canboManage.danhsachlopday', ['mamonhoc' => $mamonhoc, 'hocky' => 2]) }}">
                    <button class="btn {{ request()->is('*2') ? 'btn-success' : '' }}">Học Kì 2</button></a>
                <a href="{{ route('canboManage.bangdiemcanamlopday', ['mamonhoc' => $mamonhoc]) }}">
                    <button class="btn {{ request()->is('*3') ? 'btn-success' : '' }}">Cả Năm</button></a>
                <a href="{{ route('canboManage.excelExport', [$mamonhoc, $thongtinlop['malop'], $hocki], ) }}">
                    <button class="btn">Excel</button></a>
            </div>
        </div>
        {{-- {{ dd($mamonhoc) }} --}}
        <div class="card-body">
            <div class="table-responsive">
                <table style="width: 100%;" class="table table-bordered table-hover table-checkable" id="danhSachDiem">
                    <thead class="thead-light">
                        <tr>
                            <th rowspan="{{ $hocki < 3 ? 2 : 1 }}" class="text-center">STT</th>
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
                                <th rowspan="2" class="text-center noExport">Thao tác</th>
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
                                    @if ($key == 'tenhocsinh')
                                        <td class="text-center">{{ $v }}</td>
                                    @elseif ($key == 'tbm')
                                        <td class="text-center diem" id="tbm_{{ $value['mahocsinh'] }}">
                                            {{ $v == '' ? '' : number_format((float) $v, 1, '.', '') }}</td>
                                    @elseif ($key == 'mahocsinh')
                                        @if ($hocki < 3)
                                            <td class="text-center">
                                                <a href="{{ route('diemManage.edit', ['hocki' => $hocki, 'mamonhoc' => $mamonhoc, 'mahocsinh' => $v]) }}"
                                                    class="btn btn-primary" title="Chỉnh sửa">Chỉnh sửa</a>
                                            </td>
                                        @endif
                                    @elseif($key == 'diem')
                                        @foreach ($v as $keydiem => $diem)
                                            <td contenteditable="true" data-id="{{ $keydiem }}" data-field="diem"
                                                class="text-center editable">
                                                {{-- <input style="border: 0" class="form-control form-control-sm diem-input"
                                                    min="0" max="10" step="0.25" type="number"
                                                    value="{{ $diem != '' ? number_format((float) $diem, 2, '.', '') : '' }}"> --}}
                                                {{ $diem != '' ? number_format((float) $diem, 2, '.', '') : '' }}
                                            </td>
                                        @endforeach
                                    @endif
                                @endforeach
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
    <script>
        document.querySelectorAll('.editable').forEach(cell => {
            let oldValue = cell.innerText.trim();
            cell.addEventListener('focus', () => {
                oldValue = cell.innerText.trim();
            });

            // Khi rời ô (blur) sẽ gửi AJAX
            cell.addEventListener('blur', e => {
                const newValue = e.target.innerText.trim();
                if (parseFloat(oldValue) == parseFloat(newValue) || oldValue == newValue) {
                    console.log("Không có thay đổi")
                    e.target.innerText = oldValue;
                    return;
                }
                const id = e.target.dataset.id;
                const sodiem = e.target.dataset.field;
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
                        // console.log(data.diem_moi)
                        if (data.success) {
                            console.log('success');
                            // Cập nhật lại ô điểm - chuẩn hoá số
                            e.target.innerText = data.diem_moi;
                            const id_tbm = "tbm_" + data.mahocsinh;
                            document.getElementById(id_tbm).innerText = data.tbm;

                            e.target.style.background = 'lightgreen';
                            setTimeout(() => e.target.style.background = '', 3000);
                        } else {
                            this.innerText = oldValue; // rollback
                            alert('Lưu thất bại!');
                        }
                    });
                // .catch(err => console.error('Fetch error:', err));
                // .then(res => res.json())
                // .then(resp => {
                //     if (!resp.success) alert('Lưu không thành công!');
                // })
                // .catch(() => alert('Lỗi mạng hoặc server'));
            });

            // Optional: nhấn Enter để blur ngay
            cell.addEventListener('keydown', e => {
                if (e.key === 'Enter') {
                    e.preventDefault(); // không xuống dòng
                    e.target.blur(); // kích hoạt blur
                }
            });
        });
    </script>
@endsection
