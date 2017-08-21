@extends('_layout._ecommerce')

@section('content')
    <h1>Search for {{ $search }}</h1>
    <div class="row">
        @if(isset($products))
            @include('ecommerce._includes._products')
        @else
            <h1>No Products are available</h1>
        @endif
    </div><!-- /.row -->

@endsection