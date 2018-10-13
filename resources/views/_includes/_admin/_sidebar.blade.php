<div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;">
        <a href="{{ action('Admin\AdminHomeController@index') }}" class="site_title">
            <i class="fa fa-shopping-basket" aria-hidden="true"></i>
            <span>Lara-Commerce</span>
        </a>
    </div><!-- /.navbar navbar_title -->

    <div class="clearfix"></div>

    <div class="profile clearfix">
        <div class="profile_info">
            <span>Welcome,</span>
            <h2>{{ \Illuminate\Support\Facades\Auth::user()->fullName() }}</h2>
        </div><!-- /.profile_info -->
    </div><!-- /.profile clearfix -->

    <br />

    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
        <div class="menu_section">
            <h3>General</h3>
            <ul class="nav side-menu">
                <li>
                    <a href="{{ action('Admin\AdminHomeController@index') }}">
                        <i class="fa fa-home"></i> Home
                    </a>
                </li>
                <li>
                    <a href="{{ action('Admin\UsersController@index') }}">
                        <i class="fa fa-user" aria-hidden="true"></i>Users
                    </a>
                </li>
                <li>
                    <a href="{{ action('Admin\ProductsController@index') }}">
                        <i class="fa fa-product-hunt" aria-hidden="true"></i>Products
                    </a>
                </li>
                <li>
                    <a href="{{ action('Admin\OrdersController@index') }}">
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>Orders
                    </a>
                </li>
                <li>
                    <a href="{{ action('Admin\CategoriesController@index') }}">
                        <i class="fa fa-list-alt" aria-hidden="true"></i>Categories
                    </a>
                </li>
                <li>
                    <a href="{{ action('Admin\TaxesController@index') }}">
                        <i class="fa fa-money" aria-hidden="true"></i>Taxes
                    </a>
                </li>
                <li>
                    <a href="{{ action('Admin\StatesController@index') }}">
                        <i class="fa fa-map-o" aria-hidden="true"></i>States
                    </a>
                </li>
            </ul>
        </div><!-- /.menu_section -->
    </div><!-- /.sidebar-menu -->
</div><!-- /.left_col -->