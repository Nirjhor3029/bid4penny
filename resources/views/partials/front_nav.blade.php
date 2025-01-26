<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3">
    <div class="container">
        <a class="navbar-brand text-success fw-bold fs-4" href="#">bid penny</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link" href="#">Live Auction</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Closed Auction</a></li>
                <li class="nav-item"><a class="nav-link" href="#">How it works</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Affiliate program</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Buy Bids</a></li>
            </ul>
            <div class="d-flex gap-2">
                @auth
                    <div class="">
                        {{ Auth::user()->name }}
                        
                        <a href="{{ route('logout') }}" class="btn btn-outline-success"
                            onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                            LOGOUT
                        </a>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-success">
                        LOGIN
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-success">
                        REGISTER
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>
