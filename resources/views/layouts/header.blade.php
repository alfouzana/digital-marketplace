<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name') }}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item @if(Request::url() == url('/products')) active @endif">
                    <a class="nav-link" href="{{ url('/products') }}">
                        {{ __('Products') }}
                        @if(Request::url() == url('/products'))
                            <span class="sr-only">(current)</span>
                        @endif
                    </a>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav navbar-right">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">@lang('Login')</a>
                    </li>
                    <li class="nav-item">
                        <a  class="nav-link" href="{{ route('register') }}">@lang('Register')</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown"
                           role="button" aria-expanded="false" aria-haspopup="true">
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                @lang('Logout')
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                  style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <ul class="nav nav-pills">
        @foreach(get_secondary_navigation(str_before(Request::path(), '/')) as $name => $url)
            <li class="nav-item">
                <a href="{{ $url }}"
                   class="nav-link{{Request::url() == $url ? ' active' : '' }}"
                >{{ $name }}</a>
            </li>
        @endforeach
    </ul>
</div>