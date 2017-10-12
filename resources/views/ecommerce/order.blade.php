@extends('_layout._ecommerce')

@section('content')
    @include('_includes._ecommerce._messages')
    <order-page :cart="cart"
                :stage="'{{ $stage }}'"
                :user_order="'{{ $order }}'">
    </order-page>
@endsection

@section('scripts')
    <script src="https://checkout.stripe.com/checkout.js"></script>
@endsection