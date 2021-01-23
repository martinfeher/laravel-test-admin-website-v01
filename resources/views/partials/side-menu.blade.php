<nav>
    <div class="sidenav">
{{--        <ul class="navbar-nav flex-column">--}}
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link dropdown-indicator" href="#monitoring" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="monitoring">--}}
{{--                    <div class="d-flex align-items-center">--}}
{{--                        <span class="nav-link-icon"><i class="fas fa-clock"></i></span><span class="nav-link-text">Monitoring</span>--}}
{{--                    </div>--}}
{{--                </a>--}}
                <ul>
{{--                    <li class="nav-item"><a class="nav-link {{ (request()->is('admin/user-management')) ? 'active' : '' }}" href="/admin/user-management">User management</a></li>--}}
                    <li class="nav-item"><a class="nav-link {{ (request()->is('produkty')) ? 'active' : '' }}" href="/produkty">Produkty</a></li>
                    <li class="nav-item"><a class="nav-link {{ (request()->is('objednavky')) ? 'active' : '' }}" href="/objednavky">Objednavky</a></li>
                    <li class="nav-item"><a class="nav-link {{ (request()->is('register')) ? 'active' : '' }}" href="/register">Register user</a></li>
                </ul>
{{--                <ul class="nav collapse show" id="user_management" data-parent="#navbarVerticalCollapse">--}}
{{--                    <li class="nav-item"><a class="nav-link {{ (request()->is('user/*/edit')) ? 'active' : '' }}" href="/user/{!! Auth::user()->id !!}/edit">Password reset</a></li>--}}
{{--                </ul>--}}
{{--            </li>--}}
{{--        </ul>--}}
    </div>
</nav>
