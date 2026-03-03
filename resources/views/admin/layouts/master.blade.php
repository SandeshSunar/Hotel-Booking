<!DOCTYPE html>
<html lang="en">

@include('admin.layouts.header.index')

<body class="d-flex">

    @include('admin.layouts.header.sidebar')

    <div class="flex-grow-1 d-flex flex-column">

        @include('admin.layouts.header.navbar')

        @yield('content')
    </div>

    @include('admin.layouts.footer.index')
</body>

</html>