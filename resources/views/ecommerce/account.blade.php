@extends('_layout._ecommerce')

@section('content')
    @include('_includes._ecommerce._messages')
    <user-account :user="'{{ $user }}'">

    </user-account>
@endsection
