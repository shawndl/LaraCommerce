<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="An e-commerce application">
    <meta name="author" content="">

    <title>Lara-Commerce</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    <!-- Custom CSS -->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
            'stripeKey' => config('services.stripe.key'),
            'urls'      => \App\Library\Data\UrlData::get()
        ]); ?>
    </script>
</head>
    <body>

        <div id="app">
            <main-page inline-template>
                <div>
                    <success-message v-show="showComponents.showMessage"
                                     :message="message">

                    </success-message>
                    <error-message v-show="showComponents.showError"
                                   :error-message="errorMessage">

                    </error-message>
                    <search-products-screen v-if="showComponents.search"
                                            :token="'{{ csrf_token() }}'">

                    </search-products-screen>
                    <main-shopping-cart inline-template
                                        :show="showComponents">
                        <div>
                            @include('_includes._ecommerce._navbar')
                            <div class="container">
                                <div v-if="show.fullScreen">
                                    @include('_includes._ecommerce._messages')
                                    @yield('content')
                                </div>
                                <div class="row" v-else>
                                    <div class="col-md-3">
                                        @include('_includes._ecommerce._sidebar')
                                    </div><!-- /.col -->
                                    <div class="col-md-9">
                                        @include('_includes._ecommerce._messages')
                                        @yield('content')
                                    </div><!-- /.col -->
                                </div><!-- /.row -->
                            </div><!-- /.container -->
                        </div>
                    </main-shopping-cart>
                </div>
            </main-page>
        </div><!-- /#app -->
        @include('_includes._ecommerce._footer')
    @yield('scripts')
    <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>