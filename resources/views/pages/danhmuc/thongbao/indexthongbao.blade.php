@extends('layouts.admin.layout')
@section('content')
    <div class="mt-2 pt-2 card card-custom">
        {{-- @if (session('success'))
            <div class="alert alert-success">
                <p>{{ session('success') }}</p>
            </div>
        @endif --}}
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            {{-- @include('layout.base._pagename') --}}
            <div class="cart-title">
                <h4>Quản Lý Thông Báo</h4>
            </div>
            <hr>
            <div class="card-toolbar">
                <button class="btn btn-success" id='btnCreate'>Tạo mới</button>
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <table class="table table-hover table-checkable" id="danhSachThongBao">
                <thead>
                    <tr>
                        <th>Tiêu đề</th>
                        <th>Nội dung</th>
                        <th>Loại người gửi</th>
                        <th>Người nhận</th>
                        <th>Ngày tạo</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody id="listThongBao">
                    @foreach ($thongbao as $tb)
                        <tr>
                            <td>{{ $tb->tieude }}</td>
                            <td>{{ $tb->noidung }}</td>
                            @switch($tb->loainguoigui)
                                @case('bangiamhieu')
                                    <td>Ban Giám Hiệu</td>
                                @break

                                @case('hethong')
                                    <td>Hệ Thống</td>
                                @break

                                @case('giaovien')
                                    <td>Giáo Viên</td>
                                @break

                                @default
                            @endswitch
                            @switch($tb->loainguoinhan)
                                @case('hocsinh')
                                    <td>Học Sinh</td>
                                @break

                                @case('phuhuynh')
                                    <td>Phụ Huynh</td>
                                @break

                                @case('giaovien')
                                    <td>Giáo Viên</td>
                                @break
                                @case('all')
                                    <td>Tất cả</td>
                                @break

                                @default
                            @endswitch
                            <td>{{ $tb->created_at->format('d/m/Y H:i') }}</td>
                            <td class="text-center" style="display: flex; justify-content: center">
                                <a href="{{ route('thongbao.destroy', $tb->id) }}" id="delete"
                                    class="btn btn-sm btn-icon btn-danger" data-confirm-delete="true" title="xoá">
                                    <i class="la la-trash"></i>Xoá
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!--end: Datatable-->
        </div>
    </div>
    <!-- Modal Create -->
    <div class="modal fade" id="createModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tạo thông báo mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formCreate">
                        @csrf
                        <input type="hidden" name="loainguoigui" id="loainguoigui" class="form-control"
                            value="bangiamhieu">
                        <div class="mb-3">
                            <label class="form-label">Tiêu đề</label>
                            <input type="text" class="form-control" name="tieude" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nội dung</label>
                            <textarea class="form-control" name="noidung" rows="4" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Người nhận</label>
                            <select name="loainguoinhan" class="form-select" required>
                                <option value="giaovien">Giáo viên</option>
                                <option value="hocsinh">Học sinh</option>
                                <option value="phuhuynh">Phụ huynh</option>
                                <option value="tatca">Tất cả</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/crud/thongbao_datatables.js') }}"></script>
    <script>
        $(document).ready(function() {
            // CSRF setup cho Ajax
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Bấm nút Tạo mới
            $("#btnCreate").click(function() {
                $("#formCreate")[0].reset();
                $("#createModal").modal("show");
            });

            // Submit Create
            $("#formCreate").submit(function(e) {
                e.preventDefault();

                $.post("{{ route('thongbao.storeajax') }}", $(this).serialize(), function(res) {

                    let nguoigui = "";
                    switch (res.loainguoigui) {
                        case "bangiamhieu":
                            nguoigui = "Ban Giám Hiệu";
                            break;
                        case "hethong":
                            nguoigui = "Hệ Thống";
                            break;
                        case "giaovien":
                            nguoigui = "Giáo Viên";
                            break;
                        default:
                            nguoigui = "Khác";
                    }
                    let loainguoinhan = "";
                    switch (res.loainguoinhan) {
                        case "hocsinh":
                            loainguoinhan = "Học Sinh";
                            break;
                        case "phuhuynh":
                            loainguoinhan = "Phụ Huynh";
                            break;
                        case "giaovien":
                            loainguoinhan = "Giáo Viên";
                            break;
                        case "all":
                            loainguoinhan = "Tất cả";
                            break;
                        default:
                            loainguoinhan = "Khác";
                    }

                    let date = new Date(res.created_at);
                    let formattedDate = ("0" + date.getDate()).slice(-2) + "/" +
                        ("0" + (date.getMonth() + 1)).slice(-2) + "/" +
                        date.getFullYear() + " " +
                        ("0" + date.getHours()).slice(-2) + ":" +
                        ("0" + date.getMinutes()).slice(-2);

                    $("#listThongBao").prepend(`
            <tr id="tb_${res.id}">
                <td>${res.tieude}</td>
                <td>${res.noidung}</td>
                <td>${nguoigui}</td>
                <td>${loainguoinhan}</td>
                <td>${formattedDate}</td>
                <td class="text-center" style="display: flex; justify-content: center">
                                <a href="/thongbao/destroy/${res.id}"
                                   id="delete"
                                   class="btn btn-sm btn-icon btn-danger"
                                   data-confirm-delete="true"
                                   title="xoá">
                                    <i class="la la-trash"></i>Xoá
                                </a>
                </td>
            </tr>
        `);
                    // đóng modal + reset form
                    $("#createModal").modal("hide");
                    $("#formCreate")[0].reset();

                    toastr.success("Đã tạo thông báo thành công!", "Thành công");
                }).fail(function(err) {
                    console.error(err.responseText);
                    toastr.error("Có lỗi khi tạo mới!", "Lỗi");
                });
            });
        });
    </script>
@endsection
