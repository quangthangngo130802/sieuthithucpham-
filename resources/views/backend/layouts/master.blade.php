<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    {{-- <title>{{ $config_all ? $config_all->company : 'Quản lý khách sạn' }} </title> --}}
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    {{-- <link rel="icon" href="{{ asset('storage/'.$config_all->icon) }}"  type="image/x-icon" > --}}
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @include('backend.layouts.partials.style')
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" data-background-color="dark">
            @include('backend.layouts.partials.sidebar')
        </div>
        <!-- End Sidebar -->

        <div class="main-panel">
            <div class="main-header">
                @include('backend.layouts.partials.header')
            </div>

            <div class="container">
                <div class="page-inner">

                    @yield('content')
                </div>
            </div>

            <footer class="footer">
                @include('backend.layouts.partials.footer')
            </footer>
        </div>

        <!-- End Custom template -->
    </div>

    @include('backend.layouts.partials.script')

</body>

</html>
