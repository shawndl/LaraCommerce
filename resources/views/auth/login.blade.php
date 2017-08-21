@extends('_layout._ecommerce')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Login</h4>
                </div><!-- /.panel-heading -->
                <div class="panel-body">
                    <login-form :csrf_token="'{{ csrf_token() }}'"
                                :post_address="'{{ action('Auth\LoginController@login') }}'"
                                :forgot_password="'{{ route('password.request') }}'">
                    </login-form>
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.container -->
@endsection
