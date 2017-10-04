@extends('_layout._ecommerce')

@section('content')
    <div class="thumbnail">
        <img class="img-responsive" src="{{ $product->image->path }}" alt="Image of {{ $product->title }}">
        <div class="caption-full">
            <h4 class="pull-right">${{ $product->price }}</h4>
            <h4>
                <a href="#">{{ $product->title }}</a>
            </h4>
            <p>{{ $product->description }}</p>
        </div><!-- /.caption-full-->
        <div class="ratings">
            <p class="pull-right">{{ $product->reviews()->count() }} reviews</p>
            <p>
                <review-stars :stars="'{{ round($product->reviews()->avg('stars'), PHP_ROUND_HALF_UP) }}'"></review-stars>
                {{ round($product->reviews()->avg('stars'), PHP_ROUND_HALF_UP) }} stars
            </p>
        </div><!-- /.img-responsive -->
    </div><!-- /.thumbnail -->

    <div class="well">
        <div class="text-right">
            <a class="btn btn-success">Leave a Review</a>
        </div><!-- /.text-right -->

        <hr>

        @foreach($product->reviews as $review)
            <div class="row">
                <div class="col-md-12">
                    <review-stars :stars="'{{ $review->stars }}'"></review-stars>
                    {{ $review->user->username }}
                    <span class="pull-right">{{ App\Library\Format\DateFormat::daysAgo($product->updated_at) }}</span>
                    <p>{{ $review->review }}</p>
                </div><!-- /.col-->
            </div><!-- /.row-->

            <hr>
        @endforeach
    </div><!-- /.well -->

@endsection