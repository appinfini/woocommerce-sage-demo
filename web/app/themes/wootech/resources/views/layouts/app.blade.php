@include('sections.header')

@if (!is_front_page())
    @include('sections.breadcrumb')
@endif

@yield('content')

@include('sections.footer')
