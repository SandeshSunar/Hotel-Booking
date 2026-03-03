<!DOCTYPE html>
<html lang="en">

@include('user.layouts.header.index')

<body class="d-flex">

    @include('user.layouts.header.sidebar')

    <div class="flex-grow-1 d-flex flex-column">

        @include('user.layouts.header.navbar')

        @yield('content')
    </div>

    @include('user.layouts.footer.index')
</body>

</html>