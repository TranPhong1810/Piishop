@extends('client.layouts.app')
@section('title', 'Cart')
@section('content')
    <div class="col-sm-9 padding-right">
        <div class="table-responsive cart_info">
            <table class="table table-condensed ">
                <thead>
                    <tr class="cart_menu">
                        <td class="image"><strong>Item</strong></td>
                        <td class="price"><strong>Price</strong></td>
                        <td class="description"><strong>Sale</strong></td>
                        <td class="quantity"><strong>Quantity</strong></td>
                        <td class="total"><strong>Total</strong></td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cart->product as $item)
                        <tr id="row-{{ $item->id }}">
                            <td class="cart_product text-breack d-flex flex-column">
                                <img src="{{ $item->product->image_path }}" alt="" style="width: 200px;">
                                <div class="text-break text-center">{{ $item->product->name }}</div>
                            </td>
                            <td class="cart_description">
                                <h4>
                                    <p style="{{ $item->product->sale ? 'text-decoration: line-through' : '' }};">
                                        ${{ $item->product->price }}
                                    </p>

                                    @if ($item->product->sale)
                                        <p style="">
                                            ${{ $item->product->sale_price }}
                                        </p>
                                    @endif
                                </h4>
                            </td>
                            <td class="cart_price">
                                {{ $item->product->sale }}%
                            </td>
                            <td class="cart_quantity">
                                <div class="input-group quantity mx-auto" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary quantity btn-minus btn-update-quantity"
                                            data-action="{{ route('client.carts.update_product_quantity', $item->id) }}"
                                            data-id="{{ $item->id }}">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input class="cart_quantity_input" type="number" name="quantity" value="1"
                                        autocomplete="off" size="2" id="productQuantityInput-{{ $item->id }}"
                                        min="1" value="{{ $item->product_quantity }}">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary btn-plus btn-plus btn-update-quantity"
                                            data-action="{{ route('client.carts.update_product_quantity', $item->id) }}"
                                            data-id="{{ $item->id }}">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td class="cart_total">
                                <span
                                    id="cartProductPrice{{ $item->id }}">${{ $item->product->sale ? $item->product->sale_price * $item->product_quantity : $item->product->price * $item->product_quantity }}</span>
                            </td>
                            <td class="cart_delete">
                                <button class="btn-remove-product"
                                    data-action="{{ route('client.carts.remove_product_quantity', $item->id) }}"><i
                                        class="fa fa-times"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <section id="do_action">
        <div class="container">
            <div class="heading">
                <h3>Cart Summary</h3>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="chose_area">
                        <form class="mb-5" method="POST" action="{{ route('client.carts.apply_oupon') }}">
                            @csrf
                            <div class="input-group">
                                <input type="text" class="form-control p-4" value="{{ Session::get('coupon_code') }}"
                                    name="coupon_code" placeholder="Coupon Code">
                                <div class="input-group-append">
                                    <button class="btn btn-primary">Apply Coupon</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="total_area">
                        <ul>
                            <li>Subtotal <span class="total-price" data-price="{{ $cart->total_price }}">${{ $cart->total_price }}</span></li>
                            <li>Coupon<span>
                                    @if (session('discount_amount_price'))
                                        <div class="d-flex justify-content-between">
                                            <h6 class="font-weight-medium coupon-div"
                                                data-price="{{ session('discount_amount_price') }}">
                                                Coupon ${{ session('discount_amount_price') }}</h6>
                                        </div>
                                    @endif
                                </span></li>
                            <li>Total <span class="total-price-all">${{ $cart->total_price }}</span></li>
                        </ul>

                        <a class="btn btn-default check_out" href="{{route('client.checkout.index')}}">Check Out</a>
                    </div>
                </div>
            </div>
        </div>
    </section><!--/#do_action-->
@endsection
@push('cart')
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.21/lodash.min.js"
        integrity="sha512-WFN04846sdKMIP5LKNphMaWzU7YpMyCU245etK3g/2ARYbPK9Ub18eG+ljU96qKRCWh+quCY7yefSmlkQw1ANQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="{{ asset('client/js/cart.js') }}"></script>
@endpush
