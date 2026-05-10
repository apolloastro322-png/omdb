<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li>
                <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg">
                    <i class="fas fa-bars"></i>
                </a>
            </li>

            <li>
                <a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none">
                    <i class="fas fa-search"></i>
                </a>
            </li>
        </ul>
    </form>

    <ul class="navbar-nav navbar-right">

        <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user"
                aria-expanded="false">

                <div class="d-sm-none d-lg-inline-block">
                    <i class="fas fa-globe"></i>
                    {{ app()->getLocale() == 'en' ? 'EN' : 'ID' }}
                </div>
            </a>

            <div class="dropdown-menu dropdown-menu-right">

                <a href="{{ route('lang.switch', 'en') }}"
                    class="dropdown-item has-icon {{ app()->getLocale() == 'en' ? 'text-primary' : '' }}">

                    <i class="fas fa-check-circle"></i>
                    {{ __('English') }}
                </a>

                <a href="{{ route('lang.switch', 'id') }}"
                    class="dropdown-item has-icon {{ app()->getLocale() == 'id' ? 'text-primary' : '' }}">

                    <i class="fas fa-check-circle"></i>
                    {{ __('Bahasa Indonesia') }}
                </a>

            </div>
        </li>

        <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">

                <img alt="image" src="{{ url('/') }}/assets/img/avatar/avatar-1.png"
                    class="rounded-circle mr-1">

                <div class="d-sm-none d-lg-inline-block">
                    {{ __('Hi') }}, {{ Auth::user()->name ?? __('Guest') }}
                </div>
            </a>

            <div class="dropdown-menu dropdown-menu-right">

                <a href="{{ route('signout') }}" class="dropdown-item has-icon text-danger">

                    <i class="fas fa-sign-out-alt"></i>
                    {{ __('Logout') }}
                </a>

            </div>
        </li>

    </ul>
</nav>
