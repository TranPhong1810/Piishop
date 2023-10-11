@extends('client.layouts.app')
@section('title', 'Product Detail')
@section('content')
    <div class="col-sm-9 padding-right">
        <form action="{{ route('client.cart.add') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <div class="product-details"><!--product-details-->
                <div class="col-sm-5">
                    <div class="view-product">
                        <img src="{{ $product->images ? asset('uploads/' . $product->images->url) : 'upload/default.jpg' }}"
                            alt="" />
                        <h3>ZOOM</h3>
                    </div>

                </div>
                <div class="col-sm-7">
                    <div class="product-information"><!--/product-information-->
                        <img src="images/product-details/new.jpg" class="newarrival" alt="" />
                        <h2>{{ $product->name }}</h2>
                        <span>
                            <span name="product_price">{{ $product->price }} đ</span>
                            <input type="text" class="form-control bg-secondary text-center" value="1">
                        </span>
                        <div class="d-flex mb-4">
                            <p class="text-dark font-weight-medium mb-0 mr-3">Size:</p>
                            @if ($product->details->isEmpty())
                                <p>Hết size</p>
                            @else
                                <form class="size">
                                    @foreach ($product->details as $size)
                                        <div class="custom-control custom-radio custom-control-inline my-3">
                                            <input type="radio" class="custom-control-input" name="product_size"
                                                value="{{ $size->size }}" id="size{{ $size->size }}">
                                            <label for="size{{ $size->size }}"
                                                class="custom-control-label">{{ $size->size }}</label>
                                        </div>
                                    @endforeach
                                </form>
                            @endif
                            <button type="submit" class="btn btn-fefault cart">
                                <i class="fa fa-shopping-cart"></i>
                                Add to cart
                            </button>
                        </div>

                        <h3>Description:</h3>
                        <div class="row w-100 h-100 mx-1">
                            {!! $product->description !!}
                        </div>
                    </div><!--/product-information-->
                </div>
            </div><!--/product-details-->
        </form>

        <div class="category-tab shop-details-tab"><!--category-tab-->
            <div class="col-sm-12">
                <ul class="nav nav-tabs">
                    <li><a href="#details" data-toggle="tab">Details</a></li>
                    <li class="active"><a href="#reviews" data-toggle="tab">Reviews</a></li>
                </ul>
            </div>
            <div class="tab-content">
                @foreach ($products->take(5) as $item)
                    <div class="tab-pane fade" id="details">
                        <div class="col-sm-3">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                    <div class="productinfo text-center">
                                        <img src="{{ $item->images ? asset('uploads/' . $item->images->url) : 'upload/default.jpg' }}"
                                            alt="" />
                                        <h2>{{ $item->price }}</h2>
                                        <p>{{ $item->name }}</p>
                                        <button type="button" class="btn btn-default add-to-cart"><i
                                                class="fa fa-shopping-cart"></i>Add to cart</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="tab-pane fade active in" id="reviews">
                    <div class="col-sm-12">
                        <h4>1 review for {{ $product->name }}</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                                labore et dolore magna aliqua.Ut enim ad minim veniam, quis nostrud exercitation ullamco
                                laboris
                                nisi ut aliquip ex ea commodo consequat.Duis aute irure dolor in reprehenderit in voluptate
                                velit esse cillum dolore eu fugiat nulla pariatur.</p>
                            <p><b>Write Your Review</b></p>

                            <form action="#">
                                <span>
                                    <input type="text" placeholder="Your Name" />
                                    <input type="email" placeholder="Email Address" />
                                </span>
                                <textarea name=""></textarea>
                                <b>Rating: </b> <img src="images/product-details/rating.png" alt="" />
                                <button type="button" class="btn btn-default pull-right">
                                    Submit
                                </button>
                            </form>
                    </div>
                </div>

            </div>
        </div><!--/category-tab-->



    </div>

@endsection
