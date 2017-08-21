@extends('_layout._ecommerce')

@section('content')
    <i class="fa fa-align-justify" aria-hidden="true"></i>
    <form action="user/address/1" method="post">
        {{ action('User\API\AddressController@update', ['address' => 1]) }}
        {{ csrf_field() }}
        <hr>
        <input type="submit">
    </form>
@endsection


