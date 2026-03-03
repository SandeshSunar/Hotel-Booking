<!DOCTYPE html>
<html lang="en">
<head>
    @include('web.layouts.header.index')
</head>
<body>
    @include('web.layouts.header.nav')

    <main>
        @yield('content')
    </main>

    @include('web.layouts.footer.index')

</body>
</html>
