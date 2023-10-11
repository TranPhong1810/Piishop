<div class="container">
    <div class="row">
        <div class="col-sm-4">
            <div class="logo pull-left">
                <a href="{{route('home')}}"><img width="200px" src="{{ asset('client/images/shop/3.png') }}" alt="" /></a>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="shop-menu pull-right">
                <ul class="nav navbar-nav">
                    <li><a href="#"><i class="fa fa-user"></i> Account</a></li>
                    <li><a href="#"><i class="fa fa-star"></i> Wishlist</a></li>
                    <li><a href="checkout.html"><i class="fa fa-crosshairs"></i> Checkout</a></li>
                    <li><a href="{{route('client.cart.index')}}"><i class="fa fa-shopping-cart"></i> Cart <span id="productCountCart">{{$countProductInCart}}</span></a></li>
                    <li><a href="login.html"><i class="fa fa-lock"></i> Login</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
