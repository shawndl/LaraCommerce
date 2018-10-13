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
                <search-products>

                </search-products>
                <li>
                    <a href="{{ action('HomeController@index') }}">Home</a>
                </li>
                <li>
                    <a href="{{ action('HomeController@about') }}">About</a>
                </li>
                <li>
                    <a href="{{ action('HomeController@contact') }}">Contact</a>
                </li>
                @if($isAdmin)
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="admin-page">Admin Page<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ action('Admin\AdminHomeController@index') }}">Home Page</a></li>
                            <li><a href="{{ action('Admin\UsersController@index') }}">Users Page</a></li>
                            <li><a href="{{ action('Admin\ProductsController@index') }}">Products Page</a></li>
                            <li><a href="{{ action('Admin\OrdersController@index') }}">Orders Page</a></li>
                            <li><a href="{{ action('Admin\CategoriesController@index') }}">Categories Page</a></li>
                            <li><a href="{{ action('Admin\TaxesController@index') }}">Taxes Page</a></li>
                            <li><a href="{{ action('Admin\StatesController@index') }}">States Page</a></li>
                        </ul>
                    </li>
                @endif
                <categories-navbar v-if="!show.showSideBar"
                                   :categories="{{ $categories }}">

                </categories-navbar>
            </ul>
            <ul class="nav navbar-nav navbar-right">
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
                    <li class="dropdown" id="user-account">
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