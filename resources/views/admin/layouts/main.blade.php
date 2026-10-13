@include('admin.layouts.header')

@section('robots', 'noindex, nofollow')

@include('admin.layouts.sidebar')

@yield('content')


@include('admin.layouts.footer')
