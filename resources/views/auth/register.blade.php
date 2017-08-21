@extends('_layout._ecommerce')

@section('content')

    <div class="panel panel-primary">
        <div class="panel-heading">
            Register
        </div><!-- panel-header -->
        <div class="panel-body">
            <registration-form :csrf_token="'{{ csrf_token() }}'"
                               :post_address="'{{ route('register') }}'">

            </registration-form>
        </div><!-- panel-body -->
    </div><!-- panel -->

@endsection
