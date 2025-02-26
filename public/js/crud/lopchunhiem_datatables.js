$('#danhSachLopChuNhiem').DataTable({
    reponsive : "true",
    columnDefs: [
        {
            target: 0,
            width: '100px',
        }
    ],
    "language": {
        // "sProcessing":    "Procesando...",
        "sLengthMenu":    "Hiển thị _MENU_mục trên mỗi trang",
        "sZeroRecords":   "Không tìm thấy kết quả",
        "sEmptyTable":    "Chưa có dữ liệu",
        "sInfo":          "Hiển thị từ _START_ đến _END_ trong tổng số _TOTAL_ mục",
        "sInfoEmpty":     "Hiển thị từ 0 đến 0 trong tổng số 0 mục",
        "sInfoFiltered":  "(được lọc từ tổng số _MAX_ mục)",
        "sInfoPostFix":   "",
        "sSearch":        "Tìm kiếm:",
        "sUrl":           "",
        "sInfoThousands":  ",",
        // "sLoadingRecords": "Cargando...",
        // "oPaginate": {
        //     "sFirst":    "Đầu trang",
        //     "sLast":    "Trước đó",
        //     "sNext":    "Tiếp theo",
        //     "sPrevious": "Cuối trang"
        // },
        // "oAria": {
        //     "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
        //     "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        // }
    }
});
