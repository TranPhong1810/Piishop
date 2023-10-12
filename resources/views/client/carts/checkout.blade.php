@extends('client.layouts.app')
@section('title', 'Cart')
@section('content')
    <section id="cart_items">
        <form action="{{ route('client.checkout.proccess') }}" method="post">
            @csrf
            <input type="hidden" name="user_id" value="{{$cart->user_id}}">
            <div class="col-sm-9 padding-right">
                <div class="shopper-informations">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="shopper-info">
                                <p>Shopper</p>
                                <input class="form-control" type="text" value="{{ old('customer_name') }}"
                                    name="customer_name" placeholder="Name">
                                @error('customer_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror ()

                                <input class="form-control" name="customer_phone" value="{{ old('customer_phone') }}"
                                    type="text" placeholder="+123 456 789">
                                @error('customer_phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror ()

                            </div>
                        </div>
                        <div class="col-sm-5 clearfix">
                            <div class="bill-to">
                                <p>Bill To</p>
                                <div class="form-one">
                                    <input class="form-control" name="customer_email" value="{{ old('customer_email') }}"
                                        type="text" placeholder="example@email.com">
                                    @error('customer_email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror ()

                                    <input class="form-control" name="customer_address"
                                        value="{{ old('customer_address') }}" type="text" placeholder="123 Street">
                                    @error('customer_address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror ()
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="order-message">
                                <p>Shipping Order</p>
                                <input class="form-control" value="{{ old('note') }}" name="note" type="text"
                                    placeholder="note">
                                @error('note')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror ()
                                <input type="checkbox"> Shipping to bill address</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="review-payment">
                    <h2>Review & Payment</h2>
                </div>

                <div class="table-responsive cart_info">
                    <table class="table table-condensed">
                        <thead>
                            <tr class="cart_menu">
                                <td class="image">Item</td>
                                <td class="description"></td>
                                <td class="price">Price</td>
                                <td class="quantity"></td>
                                <td class="total"></td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cart->product as $item)
                                <tr>
                                    <td class="cart_product text-breack d-flex flex-column">
                                        <img src="{{ $item->product->image_path }}" alt="" style="width: 200px;">
                                        <div class="text-break text-center">
                                            <p>{{ $item->product_quantity }} x
                                                {{ $item->product->name }}</p>
                                        </div>
                                    </td>
                                    <td class="cart_description">


                                    </td>
                                    <td class="cart_price">
                                        <div class="pricee">
                                            <p style="{{ $item->product->sale ? 'text-decoration: line-through' : '' }};">
                                                ${{ $item->product_quantity * $item->product->price }}
                                            </p>
                                            @if ($item->product->sale)
                                                <p style="">
                                                    ${{ $item->product_quantity * $item->product->sale_price }}
                                                </p>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="cart_quantity">
                                    </td>
                                    <td class="cart_total">
                                    </td>
                                    <td class="cart_delete">
                                        <a class="cart_quantity_delete" href=""><i class="fa fa-times"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="4">&nbsp;</td>
                                <td colspan="2">
                                    <table class="table table-condensed total-result">
                                        <tr>
                                            <td>Sub Total</td>
                                            <td class="total-price" data-price="{{ $cart->total_price }}">
                                                ${{ $cart->total_price }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Shipping</td>
                                            <td class="shipping" data-price="15000">15000đ</td>
                                            <input type="hidden" value="15000" name="ship">
                                        </tr>
                                        <tr class="shipping-cost">
                                            <td>Coupon</td>
                                            <td class="coupon-div" data-price="{{ session('discount_amount_price') }}">
                                                {{ session('discount_amount_price') }}đ
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Total</td>
                                            <td><span class="total-price-all" data-price="{{ $cart->total_price }}">
                                                    đ</span></td>
                                            <input type="hidden" name="total" id="total" value="">
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="payment-options">
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" checked value="monney" name="payment">
                                <label class="custom-control-label">Money</label>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <button class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3">Place
                            Order</button>
                    </div>
                </div>
            </div>
        </form>
    </section> <!--/#cart_items-->
@endsection
@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script>
        $(function() {


            getTotalValue()

            function getTotalValue() {
                let total = parseFloat($(".total-price").data("price"));
                let couponPrice = parseFloat($(".coupon-div").data("price")) || 0;
                let shiping = parseFloat($(".shipping").data("price")) || 0;
                let totalPriceAll = total + shiping - couponPrice;
                $(".total-price-all").text(`${totalPriceAll}đ`);
                $('#total').val(totalPriceAll);
                console.log(totalPriceAll);
            }

        });
    </script>
@endpush
