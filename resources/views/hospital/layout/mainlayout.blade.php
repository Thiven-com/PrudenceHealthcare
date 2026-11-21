<!DOCTYPE html>
@include('hospital.layout.partials.theme-settings')

<head>
    @include('hospital.layout.partials.title-meta')

    @include('hospital.layout.partials.head-css')
</head>

@include('hospital.layout.partials.body')

@component('hospital.components.loader')
@endcomponent

<!-- Main Wrapper -->
@include('hospital.layout.partials.main-wrapper')

@if (!Route::is('hospital.login', 'hospital.register', 'hospital.register.verify'))
    @include('hospital.layout.partials.topbar')
    @include('hospital.layout.partials.sidebar')
    @include('hospital.layout.partials.horizontal-sidebar')
    @include('hospital.layout.partials.twocolumn-sidebar')
@endif

@yield('content')

</div>
<!-- /Main Wrapper -->

@component('hospital.components.modalpopup')
@endcomponent

@include('hospital.layout.partials.vendor-scripts')

</body>

</html>