<!DOCTYPE html>
<html>


<!-- Mirrored from id.tenten.vn/loginNavi by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 04 Dec 2024 01:24:10 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>
    <title>Liên hệ hợp tác</title>
    <!-- css -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/6.0.0-beta1/css/tempus-dominus.min.css">

    <link rel="stylesheet" type="text/css" href="{{ asset('auth/css/style.css') }}">
    <link rel="icon" href="https://sgomedia.vn/wp-content/uploads/2023/06/cropped-favicon-sgomedia-32x32.png"
        type="image/x-icon">
    <!-- js -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.marquee/1.5.0/jquery.marquee.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.pause/0.2/jquery.pause.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/6.0.0-beta1/js/tempus-dominus.min.js">
    </script>
    <style>
        table tr:last-child td {
            border-bottom: none !important;
        }
    </style>
</head>

<body class="form_page">
    <div class="container mt-4 card">
        <div class="row">
            <!-- Cột trái -->
            <div class="col-md-7 mb-4">
                <div class="">
                    <div class="card-body">
                        <table class="table">
                            <div class="card-body">

                                <table class="table">
                                    <tbody>
                                        @foreach ($relationships as $index => $item)
                                            @if ($index % 4 == 0)
                                                <tr
                                                    class="{{ $loop->last || $loop->remaining <= 4 ? '' : 'border-bottom' }}">
                                            @endif

                                            <td class="text-center px-3 {{ $index % 4 != 3 ? 'border-end' : '' }}">
                                                <img src="{{ asset('storage/' . $item->image) }}" class="img-fluid"
                                                    style="width: 100%; height: 60px; object-fit: cover;"
                                                    alt="Ảnh {{ $index + 1 }}">
                                            </td>

                                            @if ($index % 4 == 3 || $loop->last)
                                                </tr>
                                            @endif
                                        @endforeach



                                </table>
                            </div>
                    </div>
                </div>

                <!-- Cột phải -->
                <div class="col-md-5 mb-4">
                    <div class="h-100">
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <h3>Thông tin liên hệ</h3>
                            </div>

                            <form method="POST" id="form-login" action="{{ route('partner.submit') }}">
                                @csrf

                                <div class="mb-3">
                                    <input type="text" name="fullname" class="form-control" placeholder="Họ và tên"
                                        autocomplete="off">
                                    <div class="text-danger mt-1 error-fullname"></div>
                                </div>
                                <div class="mb-3">
                                    <input type="email" name="email" class="form-control"
                                        placeholder="Địa chỉ Email" autocomplete="off">
                                    <div class="text-danger mt-1 error-email"></div>
                                </div>
                                <div class="mb-3">
                                    <input type="text" name="phone" class="form-control"
                                        placeholder="Số điện thoại" autocomplete="off">
                                    <div class="text-danger mt-1 error-phone"></div>
                                </div>
                                <div class="mb-3">
                                    <textarea name="message" class="form-control" rows="3" placeholder="Lời nhắn"></textarea>
                                    <div class="text-danger mt-1 error-message"></div>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Liên hệ</button>
                                </div>
                            </form>


                            <div class="text-end mt-3" style="display: none;">
                                <a href="#" class="btn btn-link">Tạo tài khoản</a>
                                <a href="#" class="btn btn-link">Quên mật khẩu?</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Toastr -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        @if (session('success'))
            <script>
                $(document).ready(function() {
                    toastr.success("{{ session('success') }}", "Thông báo");
                });
            </script>
        @endif


        <script>
            document.getElementById('form-login').addEventListener('submit', function(e) {
                e.preventDefault(); // Chặn submit mặc định

                // Xoá hết lỗi cũ
                document.querySelectorAll('.text-danger').forEach(el => el.textContent = '');

                let hasError = false;

                const fullname = this.fullname.value.trim();
                const email = this.email.value.trim();
                const phone = this.phone.value.trim();
                const message = this.message.value.trim();

                // Kiểm tra họ tên
                if (!fullname) {
                    document.querySelector('.error-fullname').textContent = 'Vui lòng nhập họ và tên.';
                    hasError = true;
                }

                // Kiểm tra email
                if (!hasError && !email) {
                    document.querySelector('.error-email').textContent = 'Vui lòng nhập email.';
                    hasError = true;
                } else if (!hasError && !/^\S+@\S+\.\S+$/.test(email)) {
                    document.querySelector('.error-email').textContent = 'Email không hợp lệ.';
                    hasError = true;
                }

                // Kiểm tra số điện thoại
                if (!hasError && !phone) {
                    document.querySelector('.error-phone').textContent = 'Vui lòng nhập số điện thoại.';
                    hasError = true;
                } else if (!hasError && !/^\d{9,11}$/.test(phone)) {
                    document.querySelector('.error-phone').textContent = 'Số điện thoại không hợp lệ.';
                    hasError = true;
                }

                // Kiểm tra lời nhắn
                if (!hasError && !message) {
                    document.querySelector('.error-message').textContent = 'Vui lòng nhập lời nhắn.';
                    hasError = true;
                }

                // Nếu không có lỗi, submit form
                if (!hasError) {
                    this.submit();
                }
            });
        </script>
</body>


<!-- Mirrored from id.tenten.vn/loginNavi by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 04 Dec 2024 01:24:11 GMT -->

</html>
