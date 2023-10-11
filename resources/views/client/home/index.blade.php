@extends('client.layouts.app')
@section('content')
    <div class="col-sm-9 padding-right">
        <div class="features_items"><!--features_items-->
            <h2 class="title text-center">STORE</h2>
            @foreach ($products as $item)
                <div class="col-sm-4">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <img width="40px"
                                    src="{{ $item->images ? asset('uploads/' . $item->images->url) : 'upload/default.jpg' }}"
                                    alt="">
                                <p>{{ $item->name }}</p>

                            </div>
                            <div class="product-overlay">
                                <div class="overlay-content">
                                    <h2>{{ $item->price }}đ</h2>
                                    <p><a href="{{ route('client.product.show', $item->id) }}">{{ $item->name }}</a></p>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            @endforeach

        </div><!--features_items-->
        <div class="">
            {{ $products->links() }}
        </div>

    </div>
@endsection
