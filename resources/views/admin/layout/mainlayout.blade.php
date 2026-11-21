<!DOCTYPE html>
@include('admin.layout.partials.theme-settings')

<head>
    @include('admin.layout.partials.title-meta')

    @include('admin.layout.partials.head-css')
</head>

@include('admin.layout.partials.body')

@component('admin.components.loader')
@endcomponent

<!-- Main Wrapper -->
@include('admin.layout.partials.main-wrapper')

@if (!Route::is('admin.login'))
    @include('admin.layout.partials.topbar')
    @include('admin.layout.partials.sidebar')
    @include('admin.layout.partials.horizontal-sidebar')
    @include('admin.layout.partials.twocolumn-sidebar')
@endif

@yield('content')

</div>
<!-- /Main Wrapper -->

@component('admin.components.modalpopup')
@endcomponent

@include('admin.layout.partials.vendor-scripts')

</body>

</html>