<nav class="navbar navbar-expand-lg" style="background-color: #F5F5F5;">
    <div class="container-fluid">
        <!-- Title  -->
        <a class="navbar-brand text-dark" href="/dashboard">Database Management ToyStore</a>

        <!-- Navbar toggle button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar items -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link text-dark" aria-current="page" href="/dashboard">Transaksi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="/toy">Product</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="/supplier">Supplier</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="/customer">Customer</a>
                </li>
            </ul>

            <form class="d-flex" method="post" action="/logout">
                @csrf
                <button class="btn btn-outline-dark" type="submit">Log Out</button>
            </form>
        </div>
    </div>
</nav>
