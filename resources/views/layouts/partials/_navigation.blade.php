<nav class="nav">
    <div class="container">
        <div class="nav-left">
            <a href="{{ route('home') }}" class="nav-item is-brand">
                {{ config('app.name') }}
            </a>
        </div>


        <div class="nav-right nav-menu">
            @if(auth()->check())
                <a href="{{ route('logout') }}" class="nav-item" onclick="event.preventDefault(); document.getElementById('logout').submit();">
                    Sign out
                </a>

                <a href="{{ route('account') }}" class="nav-item">
                    Your Account
                </a>

                @role('admin')
                    <a href="{{ route('admin.index') }}">Admin</a>
                @endrole
            @else
                <a href="{{ route('login') }}" class="nav-item">
                    Sign in
                </a>

                <a href="{{ route('register') }}" class="nav-item">
                    Sign up
                </a>
            @endif
        </div>
    </div>
</nav>

<form action="{{ route('logout') }}" method="POST" id="logout" class="is-hidden">
    {{ csrf_field() }}
</form>
