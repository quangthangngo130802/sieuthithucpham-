@extends('backend.layouts.master')

@section('content')
    @include('backend.layouts.partials.breadcrumb', ['page' => 'Quản lý đối tác'])

    <div class="row">
        <!-- Form Thêm/Sửa Bài Viết -->
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Thêm/Sửa đối tác</h5>
                </div>
                <div class="card-body">
                    <form id="postForm" enctype="multipart/form-data" action="{{ route('admin.relationship.store') }}">

                        <input type="hidden" name="id" id="postId">

                        <div class="mb-3">
                            <label for="link" class="form-label">Link <span class="text-danger">*</span></label>
                            <input id="link" name="link" class="form-control" type="text"
                                placeholder="Nhập link">
                            <div class="error-message text-danger"></div>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Ảnh <span class="text-danger">*</span></label>
                            <img class="img-fluid img-thumbnail w-100" id="show_image"
                                style="cursor: pointer; height: 300px !important;" src="{{ showImage($post->image ?? '') }}"
                                alt="" onclick="document.getElementById('image').click();">
                            <input type="file" name="image" id="image" class="form-control d-none" accept="image/*"
                                onchange="previewImage(event, 'show_image')">
                        </div>


                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary" id="save">Lưu</button>
                            <button type="button" id="cancelEdit" style="display: none"
                                class="btn btn-secondary ms-2">Hủy</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Danh sách bài viết -->
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-content-center">
                    <h3 class="card-title">DANH SÁCH ĐỐI TÁC</h3>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="myTable" class="display" style="width:100%">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('backend/assets/js/plugin/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/columns/function.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('backend/assets/css/image-uploader.min.css') }}">
    <script src="{{ asset('backend/assets/js/connectDataTable.js') }}"></script>
    <script>
        $(document).ready(function() {
            const api = '/admin/relationship';

            dataTables(api, columns, 'Relationship')

            $('#save').off('click').click(function(event) {
                if (!validateForm()) {
                    event.preventDefault();
                    return; // Dừng nếu có lỗi
                }
                submitForm('#postForm', function(event) {

                    $('#myTable').DataTable().ajax.reload(); // Reload bảng sau khi lưu
                    reset();
                })
            })

            $(document).on('click', '.edit', function() {
                let link = $(this).data('link');
                let image = $(this).data('image'); // Ảnh từ data-image
                let id = $(this).closest('tr').data('id'); // Lấy ID từ hàng
                $('#postForm').append('<input type="hidden" name="_method" value="PUT">');
                // Gán dữ liệu vào form
                $('#link').val(link);
                // $('#image').val(image);
                $('#postId').val(id);

                // Xây dựng đường dẫn ảnh sử dụng hàm showImage
                let imageUrl = "{{ asset('storage') }}/" + image;

                // Hiển thị ảnh trong form
                $('#show_image').attr('src', imageUrl);

                // Đổi action form thành sửa
                $('#postForm').attr('action', "{{ route('admin.relationship.update', '') }}/" + id);
                $('#cancelEdit').show();
                $('#cancelEdit').on('click', function() {
                    reset()
                });
            });

            function validateForm() {
                let isValid = true;
                $('.error-message').text('').hide();

                let link = $('#link').val().trim();

                if (!link) {
                    $('#link').next('.error-message').text('Vui lòng nhập link').show();
                    isValid = false;
                }

                return isValid;
            }

            function reset() {
                $('#postForm').attr('action', "{{ route('admin.relationship.store') }}");
                $('#postForm')[0].reset();
                $('#postId').val('');
                $('#show_image').attr('src', '{{ showImage('') }}');
                $('#postForm input[name="_method"]').remove();
                $('#cancelEdit').hide();

            }

        })
    </script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/dataTables.min.css') }}">
@endpush
