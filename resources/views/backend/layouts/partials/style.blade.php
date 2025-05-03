
<!-- Fonts and icons -->
<script src="{{ asset('backend/assets/js/plugin/webfont/webfont.min.js') }}"></script>
<script>
    WebFont.load({
        google: {
            families: ["Public Sans:300,400,500,600,700"]
        },
        custom: {
            families: [
                "Font Awesome 5 Solid",
                "Font Awesome 5 Regular",
                "Font Awesome 5 Brands",
                "simple-line-icons",
            ],
            urls: ["{{ asset('backend/assets/css/fonts.min.css') }}"],
        },
        active: function() {
            sessionStorage.fonts = true;
        },
    });
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- CSS Files -->
<link rel="stylesheet" href="{{ asset('backend/assets/css/bootstrap.min.css') }}" />
<link rel="stylesheet" href="{{ asset('backend/assets/css/plugins.min.css') }}" />
<link rel="stylesheet" href="{{ asset('backend/assets/css/kaiadmin.min.css') }}" />

<!-- CSS Just for demo purpose, don't include it in your project -->
<link rel="stylesheet" href="{{ asset('backend/assets/css/demo.css') }}" />

<style>
    form label {
        font-weight: bold;
    }

    table thead tr th,
    table thead tr td,
    table tbody tr th,
    table tbody tr td {
        font-size: 0.9em;
    }

    .nav.nav-tabs {
        border: none
    }

    .breadcrumb {
        background: #ffffff;
        border-radius: 8px;
        padding: 10px 15px;

        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        /* Đảm bảo không bị vỡ layout trên màn hình nhỏ */
    }

    .breadcrumb .breadcrumb-item {
        display: flex;
        align-items: center;
    }

    .breadcrumb-item a {
        text-decoration: none;
        color: #007bff;
        font-weight: 500;
    }

    .breadcrumb-item a:hover {
        text-decoration: underline;
        color: #0056b3;
    }

    .breadcrumb-item.active {
        color: #6c757d;
        font-weight: 600;
    }

    .breadcrumb li:last-child {
        margin-left: auto;
        /* Đẩy phần tử cuối về bên phải */
    }

    .switch {
  font-size: 12px;
  position: relative;
  display: inline-block;
  width: 3.5em;
  height: 2em;
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  transition: 0.4s;
  border-radius: 10px;
}

.slider:before {
  position: absolute;
  content: '';
  height: 1.4em;
  width: 1.4em;
  border-radius: 5px;
  left: 0.3em;
  bottom: 0.33333333333em;
  background-color: white;
  transition: 0.2s all ease-in-out;
}

.switch input:checked + .slider {
  background-color: green;
}

.switch input:checked + .slider:before {
  transform: translateX(1.5em);
}
</style>

@stack('styles')
