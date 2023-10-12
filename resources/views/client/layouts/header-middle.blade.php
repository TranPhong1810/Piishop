<div class="container">
    <div class="row">
        <div class="col-sm-4">
            <div class="logo pull-left">
                <a href="{{ route('home') }}"><img width="200px" src="{{ asset('client/images/shop/3.png') }}"
                        alt="" /></a>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="shop-menu pull-right">
                <ul class="nav navbar-nav">

                    <li><a href="{{ route('client.cart.index') }}"><i class="fa fa-shopping-cart"></i> Cart <span
                                id="productCountCart">{{ $countProductInCart }}</span></a></li>
                    @if (auth()->check())
                        <li><a href="#"><i class="fa fa-user"></i> Account</a></li>
                        <div>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    @else
                        <li><a href="{{ route('login') }}"><i class="fa fa-lock"></i> Login</a></li>
                        <li><a href="login.html"><i class="fa fa-lock"></i> Register</a></li>
                    @endif

                </ul>
            </div>
        </div>
    </div>
</div>
