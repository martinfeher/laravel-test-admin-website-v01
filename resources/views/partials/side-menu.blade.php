<nav>
    <div class="sidenav">
        <ul>
            <li class="nav-item"><a class="nav-link {{ (request()->is('produkty')) ? 'active' : '' }}" href="/produkty">Produkty</a></li>
            <li class="nav-item"><a class="nav-link {{ (request()->is('objednavky')) ? 'active' : '' }}" href="/objednavky">Objednávky</a></li>
            <li class="nav-item"><a class="nav-link {{ (request()->is('pouzivatelia')) ? 'active' : '' }}" href="/pouzivatelia">Používatelia</a></li>
            <li class="nav-item"><a class="nav-link {{ (request()->is('register')) ? 'active' : '' }}" href="/register">Registrovať používateľa</a></li>
        </ul>
    </div>
</nav>
