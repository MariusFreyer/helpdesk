<nav class="navbar navbar-expand-md bg-secondary navbar-dark">
    <div class="container">
        <!-- Brand -->
        <a class="navbar-brand" href="/">IT Helpdesk</a>
        <!-- Toggler/collapsibe Button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav mr-auto">
                @if(Auth::check()) 
                @if (Auth::user()->hasRole('admin') || (Auth::user()->hasRole('supporter')))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('index_ticket') }}">Ticket overview</a>
                </li>
                @endif 
                @if (Auth::user()->hasRole('user'))
                <li class="nav-item">
                    <a class="nav-link" href="#">My Tickets</a>
                </li>
                <li class="nav-item">
                        <a class="nav-link" href="#">FAQ</a>
                    </li>
                @endif 
                @endif
            </ul>
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                <li><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                <li><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>