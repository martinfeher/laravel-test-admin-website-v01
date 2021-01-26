<nav class="navbar navbar-light navbar-glass navbar-top navbar-expand" style="min-height: 69px;">
{{--    <a class="navbar-brand mr-1 mr-sm-3" href="/" style="margin-bottom: 2px;">logo</a>--}}
    <ul class="navbar-nav ml-auto flex-row align-items-center">
        <li class="user_top_menu mr-4">
            <span class="top_menu_meno">{{ Auth::user()->meno }} &nbsp;</span><span class="top_menu_rola">{{ Auth::user()->rola }}</span>
        </li>
        <li>
            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Odhlásiť</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
        </li>
    </ul>
</nav>
