@if (session('success'))
    <script>

        $.notify({
            icon: 'icon-bell',
            title: 'Thông báo',
            message: '{{ session('success') }}',
        }, {
            type: 'success',
            placement: {
                from: "top",
                align: "right",
            },
            time: 1000
        });
    </script>
@elseif (session('error'))
    <script>
        $.notify({
            icon: 'fa fa-times-circle',
            title: 'Có lỗi xảy ra. Vui lòng kiểm tra lại!',
            message: '{{ session('error') }}',
        }, {
            type: 'danger',
            placement: {
                from: "top",
                align: "right",
            },
            time: 1000,
        });
    </script>
@endif
