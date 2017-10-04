<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Lara-Commerce Admin</title>

        <!-- Bootstrap Core CSS -->
        <link rel="stylesheet" href="{{ mix('/css/admin.css') }}">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script>
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
                'urls'      => \App\Library\Data\AdminUrlData::get()
            ]); ?>
        </script>
    </head>
    <body>
        <div id="app">
            <admin-main-page inline-template>
                <div :class="{'nav-md' : showComponents.showSideBar, 'nav-sm' : !showComponents.showSideBar}">
                    <div class="container body">
                        <div class="main_container">
                            <success-message v-show="showComponents.showMessage"
                                             :message="message">

                            </success-message>
                            <error-message v-show="showComponents.showError"
                                           :error-message="errorMessage">

                            </error-message>
                            <div class="col-md-3 left_col">
                                @include('_includes._admin._sidebar')
                            </div><!-- /.col -->
                            @include('_includes._admin._navbar')
                            <div class="right_col" role="main">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        @include('_includes._ecommerce._messages')
                                        @yield('content')
                                    </div><!-- /.col -->
                                </div><!-- /.row -->
                            </div><!-- /.right_col -->
                            @include('_includes._admin._footer')
                        </div><!-- /.main_container -->
                    </div><!-- /.container -->
                </div><!-- /.nav-md -->
            </admin-main-page>
        </div><!-- vue root -->
        @yield('scripts')
        <script src="{{ mix('js/admin.js') }}"></script>
    </body>
</html>