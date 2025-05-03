<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('admin.relationship.index') }}"><i class="fas fa-home"></i> Trang chủ</a>
        </li>
        @isset($page)
            <li class="breadcrumb-item active" aria-current="page">
                <i class="fas fa-file-alt me-2"></i> {{ $page }}
            </li>
        @endisset

        <li>
            @isset($href)
                <a href="{{ $href }}" class="btn btn-secondary btn-sm"> <i class="fas fa-backward me-1"></i>Quay
                    lại</a>
            @endisset

        </li>
    </ol>
</nav>
