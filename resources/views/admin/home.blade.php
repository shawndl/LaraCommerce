@extends('_layout._admin')

@section('content')
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default panel-categories">
                <div class="panel-heading">
                    Users Page
                    <i class="fa fa-user pull-right" aria-hidden="true"></i>
                </div><!-- /.panel-heading -->
                <div class="panel-body">
                    The users' page contains information all the users registered at your site.  View users' details including user's addresses and orders.
                    <br />
                    <a href="{{ action('Admin\UsersController@index')  }}" class="btn btn-info">Users</a>
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->
        </div><!-- /.col -->
        <div class="col-sm-6">
            <div class="panel panel-default panel-categories">
                <div class="panel-heading">
                    Products Page
                    <i class="fa fa-product-hunt pull-right" aria-hidden="true"></i>
                </div><!-- /.panel-heading -->
                <div class="panel-body">
                    The products' page contains information all the products on your site.  Mangage your products at this page including adding new products or sales.
                    <br />
                    <a href="{{ action('Admin\ProductsController@index')  }}" class="btn btn-info">Products</a>
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->
        </div><!-- /.col -->
    </div><!-- /.row -->
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default panel-categories">
                <div class="panel-heading">
                    Orders Page
                    <i class="fa fa-shopping-cart pull-right" aria-hidden="true"></i>
                </div><!-- /.panel-heading -->
                <div class="panel-body">
                    The orders' page contains information all orders placed on your site  Inform your customers that their orders have been shipped from this page.
                    <br />
                    <a href="{{ action('Admin\OrdersController@index')  }}" class="btn btn-info">Orders</a>
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->
        </div><!-- /.col -->
        <div class="col-sm-6">
            <div class="panel panel-default panel-categories">
                <div class="panel-heading">
                    Categories Page
                    <i class="fa fa-list-alt pull-right" aria-hidden="true"></i>
                </div><!-- /.panel-heading -->
                <div class="panel-body">
                    The categories' page allows you to manage the categories that your products can be organised into.
                    <br />
                    <a href="{{ action('Admin\CategoriesController@index')  }}" class="btn btn-info">Categories</a>
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->
        </div><!-- /.col -->
    </div><!-- /.row -->
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default panel-categories">
                <div class="panel-heading">
                    Taxes Page
                    <i class="fa fa-money pull-right" aria-hidden="true"></i>
                </div><!-- /.panel-heading -->
                <div class="panel-body">
                    The taxes' page contains information all taxes that can be charged on products.
                    <br />
                    <a href="{{ action('Admin\TaxesController@index')  }}" class="btn btn-info">Taxes</a>
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->
        </div><!-- /.col -->
    </div><!-- /.row -->

@endsection
