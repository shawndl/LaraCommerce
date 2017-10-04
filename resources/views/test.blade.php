@extends('_layout._admin')

@section('content')
    <img src="{{ $image->path }}" alt="">
    <hr>
    <img src="{{ $image->thumbnail }}" alt="">
@endsection

