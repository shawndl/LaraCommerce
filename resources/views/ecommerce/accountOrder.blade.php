@extends('_layout._ecommerce')

@section('content')
    <user-order :order_id="'{{ $order_id }}'"
                :need_total="true">

    </user-order>
@endsection
