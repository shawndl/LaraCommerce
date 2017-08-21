<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div><!-- /.navbar-header -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li>
                    <a href="{{ action('HomeController@index') }}">Home</a>
                </li>
                <li>
                    <a href="{{ action('HomeController@about') }}">About</a>
                </li>
                <li>
                    <a href="{{ action('HomeController@contact') }}">Contact</a>
                </li>
                <categories-navbar v-if="!showComponents.showSideBar"
                                   :categories="{{ $categories }}">

                </categories-navbar>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <search-products :token="'{{ csrf_token() }}'">

                </search-products>
                <navbar-cart :cart="cart"
                             @remove-item="removeItem"
                             @update-quantity="updateCart">

                </navbar-cart>
                @if (Auth::guest())
                    <li>
                        <a href="{{ url('/login') }}">
                            <i class="fa fa-sign-in" aria-hidden="true"></i>
                            Login
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/register') }}">
                            <i class="fa fa-registered" aria-hidden="true"></i>
                            Register
                        </a>
                    </li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle"
                           data-toggle="dropdown"
                           role="button"
                           aria-expanded="false">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            {{ Auth::user()->username }}'s Account
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ action('User\UserAccountController@index') }}"> My Account </a></li>
                            <li><a href="{{ action('Auth\LoginController@logout') }}">Logout</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container -->
</nav>