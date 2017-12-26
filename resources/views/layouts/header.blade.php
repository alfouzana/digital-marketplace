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
        </div>
    </div>
</nav>