@extends('admin.layouts.app')
@section('title', 'Show Product ' . $product->name)
@section('content')
    <div class="main-content-inner">
        <!-- main-content-wrap -->
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Product Detail</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="index.html">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <a href="#">
                            <div class="text-tiny">Ecommerce</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Product Detail</div>
                    </li>
                </ul>
            </div>
            <!-- Product Detail -->
            <div class="wg-box">
                <div class="tf-main-product section-image-zoom flex">
                    <div class="tf-product-media-wrap">
                        <div class="thumbs-slider">
                            <div class="swiper tf-product-media-main" id="gallery-swiper-started">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="item">
                                            <img src="{{ $product->images ? asset('uploads/' . $product->images->url) : 'upload/default.jpg' }}"
                                                alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tf-product-info-wrap relative flex-grow">
                        <div class="tf-zoom-main"></div>
                        <div class="tf-product-info-list other-image-zoom">
                            <div class="tf-product-info-title">
                                <h3>{{ $product->name }}</h3>
                                <div class="price body-title">{{ number_format($product->sale_price) }} ₫</div>
                            </div>
                            <div class="tf-product-info-variant-picker">
                                <div class="variant-picker-item">
                                    @foreach ($product->details as $item)
                                        <div class="variant-picker-label body-text">
                                            Size: <span
                                                class="body-title-2 variant-picker-label-value">{{ $item->size }}</span>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="variant-picker-item">
                                    @foreach ($product->details as $item)
                                        <div class="variant-picker-label body-text">
                                            Quantity: <span
                                                class="body-title-2 variant-picker-label-value">{{ $item->quantity }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- /Product Detail -->
        </div>
        <!-- /main-content-wrap -->
    </div>
@endsection
