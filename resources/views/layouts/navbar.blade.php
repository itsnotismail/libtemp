<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{URL::to('/')}}">LIBRARY</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                @auth
                <li class="nav-item"><a class="nav-link{{Request::is('home') ? ' active' : ''}}" href="{{URL::to('/home')}}">Home</a></li>
                <li class="nav-item"><a class="nav-link{{Request::is('books') ? ' active' : ''}}" href="{{URL::to('/books')}}">Books</a></li>
                <li class="nav-item"><a class="nav-link{{Request::is('borrowers') ? ' active' : ''}}" href="{{URL::to('/borrowers')}}">Borrowers</a></li>
                <li class="nav-item"><a class="nav-link{{Request::is('borrows') ? ' active' : ''}}" href="{{URL::to('/borrows')}}">Issues</a></li>
                <li class="nav-item"><a class="nav-link{{Request::is('bookReturns') ? ' active' : ''}}" href="{{URL::to('/bookReturns')}}">Returns</a></li>
                <li class="nav-item"><a class="nav-link{{Request::is('lateReturns') ? ' active' : ''}}" href="{{URL::to('/lateReturns')}}">Late Fines</a></li>
                <li class="nav-item"><a class="nav-link{{Request::is('users') ? ' active' : ''}}" href="{{URL::to('/users')}}">Users</a></li>
                @endauth
            </ul>
        </div>
        <div class="d-flex">
            <ul class="navbar-nav">
                @guest
                <li class="nav-item"><a class="nav-link{{Request::is('login') ? ' active' : ''}}" href="{{URL::to('/login')}}">Login</a></li>
                <li class="nav-item"><a class="nav-link{{Request::is('register') ? ' active' : ''}}" href="{{URL::to('/register')}}">Register</a></li>
                @endguest
                @auth
                <li class="nav-item"><a class="nav-link" href="{{URL::to('/logout')}}">Logout</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>