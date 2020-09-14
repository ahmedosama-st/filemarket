<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
       @include('layouts.partials._head')
    </head>
    <body>
        <div id="app">
            @include('layouts.partials._navigation')
            @yield('content')
        </div>

        @include('layouts.partials._scripts')
        @yield('scripts')
    </body>
</html>
