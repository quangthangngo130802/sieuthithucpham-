// Kiểm tra xem có cột dt-control hay không
const hasDtControl = columns.some((col) => col.className === "dt-control");

// Tạo <thead>
let thead = "<thead><tr>";

// Nếu có dt-control, thì thêm vào đầu tiên
if (hasDtControl) {
    thead += "<th></th>"; // Chỗ này để chừa vị trí cho dt-control
}

thead += '<th><input type="checkbox" id="selectAll" /></th>';

// Thêm các cột khác vào thead
columns.forEach(function (column) {
    if (column.className !== "dt-control") {
        thead += "<th>" + column.title + "</th>";
    }
});
thead += "</tr></thead>";

// Thêm <thead> vào bảng
$("#myTable").append(thead);

const dataTables = (api, columns, model, sortable = false) => {
    // Nếu có dt-control, đảm bảo nó ở vị trí đầu tiên
    let finalColumns = hasDtControl
        ? [
              {
                  className: "dt-control",
                  orderable: false,
                  data: null,
                  defaultContent: "",
              },
              {
                  data: "checkbox",
                  name: "checkbox",
                  orderable: false,
                  searchable: false,
                  width: "5px",
                  className: "text-center",
              },
              ...columns.filter((col) => col.className !== "dt-control"),
          ]
        : [
              {
                  data: "checkbox",
                  name: "checkbox",
                  orderable: false,
                  searchable: false,
                  width: "5px",
                  className: "text-center",
              },
              ...columns,
          ];

    const table = $("#myTable").DataTable({
        // Định nghĩa biến table
        processing: true,
        serverSide: true,
        ajax: api,
        columns: finalColumns,
        createdRow: function (row, data) {
            $(row).attr("data-id", data.id);
        },
        drawCallback: function () {
            // Kiểm tra xem có cần khởi tạo sortable hay không
            if (sortable) {
                // Khởi tạo SortableJS mỗi khi DataTables vẽ lại bảng
                new Sortable(document.querySelector("#myTable tbody"), {
                    handle: "td", // Vùng kéo thả
                    onEnd: function (evt) {
                        var order = [];
                        $("#myTable tbody tr").each(function (index) {
                            order.push($(this).data("id"));

                            $(this)
                                .find("td.position")
                                .text(index + 1);
                        });

                        // Gửi yêu cầu cập nhật thứ tự lên server
                        updateOrderInDatabase(order, model);
                    },
                });
            }
        },
        order: [],
    });

    $(document).on("click", "#cancelEditBtn", function () {
        // Đóng form mà không lưu thay đổi
        let tr = $(this).closest("tr");
        let row = table.row(tr);
        row.child.hide();
    });

    $(document).on("submit", "#myForm", function (e) {
        e.preventDefault();

        let formData = new FormData(this),
            row = table.row($(this).closest("tr"));

        formData.append("id", row.data().id);
        formData.append("_method", "PUT");
        formData.append("model", model);

        $.post({
            url: "/admin/handle-fast-update",
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                if (res.success) {
                    Toast.fire({
                        icon: "success",
                        title: res.message,
                    });
                    table.draw();
                }
            },
            error: (xhr) =>
                Toast.fire({
                    icon: "error",
                    title: xhr.responseJSON.message,
                }),
        });
    });

    table.on("requestChild.dt", function (e, row) {
        row.child(format(row.data())).show();
    });

    table.on("click", "td.dt-control", function (e) {
        let tr = e.target.closest("tr");
        let row = table.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
        } else {
            // Open this row
            row.child(format(row.data())).show();
        }
    });

    $('label[for="dt-length-0"]').remove();

    const targetDiv = $(".dt-layout-cell.dt-layout-start .dt-length");

    let _html = `
    <div id="actionDiv" style="display: none;">
        <div class="d-flex">
            <select id="actionSelect" class="form-select rounded-start" style="border-top-right-radius: 0 !important; border-bottom-right-radius: 0 !important">
                <option value="">-- Chọn hành động --</option>
                <option value="delete">Xóa</option>
            </select>
            <button id="applyAction" class="btn btn-outline-danger btn-sm rounded-end" style="border-bottom-left-radius: 0 !important; border-top-left-radius: 0 !important;">Apply</button>
        </div>
    </div>
    `;

    targetDiv.after(_html);

    $("#myTable tbody").on("click", 'input[type="checkbox"]', function () {
        const allChecked =
            $('#myTable tbody input[type="checkbox"]').length ===
            $('#myTable tbody input[type="checkbox"]:checked').length;
        $('#myTable thead input[type="checkbox"]').prop("checked", allChecked);
        toggleActionDiv();
    });

    $("#applyAction").on("click", function () {
        const selectedAction = $("#actionSelect").val();

        if (!selectedAction) return;

        const selectedIds = $(".row-checkbox:checked").toArray().map(el => el.value);

        if (selectedAction === "delete") {
            $.ajax({
                url: "/admin/delete-items",
                method: "POST",
                data: {
                    ids: selectedIds,
                    model: model,
                },
                success: function (response) {
                    table.ajax.reload(); 
                    Toast.fire({
                        icon: "success",
                        title: response.message,
                    });
                    $("#actionSelect").val("");
                    $('input[type="checkbox"]').prop("checked", false);
                    toggleActionDiv();
                },
                error: function () {
                    alert("Có lỗi xảy ra, vui lòng thử lại!");
                },
            });
        }
    });
};

function updateOrderInDatabase(order, model) {
    $.ajax({
        url: "/admin/change-order",
        method: "POST",
        data: {
            order: order,
            model: model,
        },
        success: function (response) {
            Toast.fire({
                icon: "success",
                title: response.message,
            });
        },
        error: function (xhr) {
            Toast.fire({
                icon: "error",
                title: xhr.responseJSON.message,
            });
        },
    });
}

function toggleActionDiv() {
    if ($(".row-checkbox:checked").length > 0) {
        $("#actionDiv").show();
    } else {
        $("#actionDiv").hide();
    }
}

$('#myTable thead input[type="checkbox"]').on("click", function () {
    const isChecked = $(this).prop("checked");
    $('#myTable tbody input[type="checkbox"]').prop("checked", isChecked);
    toggleActionDiv();
});

const handleDestroy = (model) => {
    $("tbody").on("click", ".btn-destroy", function (e) {
        e.preventDefault();

        if (confirm("Chắc chắn muốn xóa?")) {
            var form = $(this).closest("form");

            form.append("model", model);

            $.ajax({
                url: form.attr("action"),
                method: "POST",
                data: form.serialize(),
                success: function (response) {
                    $("#myTable").DataTable().ajax.reload();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR);
                },
            });
        }
    });
};
