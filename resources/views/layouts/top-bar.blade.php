<div class="border-bottom">
    <div class="container">
        <div class="navbar navbar-expand flex-column flex-md-row bd-navbar">
            <a href="{{ route('home') }}" class="navbar-brand mr-0 mr-md-2 logo"></a>
            <nav class="navbar-nav-scroll" role="navigation">
                <ul class="navbar-nav bd-navbar-nav flex-row">
                    @if (Request::route()->getName() === 'home')
                        <li class="nav-item">
                            <a href="{{ route('select_sign') }}" class="nav-link">Новая игра</a>
                        </li>
                    @endif
                    @if (Auth::user())
                        @if (Request::route()->getName() !== 'home')
                            <li class="nav-item">
                                <a href="{{ route('new_game') }}" class="nav-link">Новая партия</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('select_sign') }}" class="nav-link">Сменить роль</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link history-link" href="#0" data-href="{{ route('history') }}">История игр</a>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>

</div>
