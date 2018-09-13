<!DOCTYPE html>
<html>
    <head>
        @include('layout._head')

        @yield('extra_styles')
    </head>
    <body>
        <div id="wrapper">
            @include('layout._topnav')

            @include('layout._sidebar')

          <div class="content-page">

            @yield('content')

          	@include('layout._footer')

          </div>

        </div>

        @include('layout._scripts')

        @yield('extra_scripts')

    </body>
</html>
