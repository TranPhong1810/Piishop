<div class="footer-top">
    <div class="container">
        <div class="row">
            <div class="col-sm-2">
                <div class="companyinfo">
                    <div class="imgg">
                        <a href="{{ route('home') }}">
                            <h2><span>Pii</span>-Shop</h2>
                            <img width="100px" src="{{ asset('client/images/shop/3.png') }}" alt="">
                        </a>
                    </div>
                    <div class="row">
                        <p class="mb-2"><i class="fa fa-map-marker text-primary mr-3"></i> HA NOI</p>
                        <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>tranphongbackend@gmail.com</p>
                        <p class="mb-0"><i class="fa fa-phone-square text-primary mr-3"></i> +84395419293</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="footer-widget">
    <div class="container">
        <div class="row">
            <div class="col-sm-2">
                <div class="single-widget">
                    <h2>Service</h2>
                    <ul class="nav nav-pills nav-stacked">
                        <li><a href="#">Online Help</a></li>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">Order Status</a></li>
                        <li><a href="#">Change Location</a></li>
                        <li><a href="#">FAQ’s</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="single-widget">
                    <h2>Pii Shop</h2>
                    @foreach ($categories->take(5) as $item)
                        <ul class="nav nav-pills nav-stacked">
                            <li><a
                                    href="{{ route('client.product.index', ['category_id' => $item->id]) }}">{{ $item->name }}</a>
                            </li>
                        </ul>
                    @endforeach
                </div>
            </div>
            <div class="col-sm-2">
                <div class="single-widget">
                    <h2>Policies</h2>
                    <ul class="nav nav-pills nav-stacked">
                        <li><a href="#">Terms of Use</a></li>
                        <li><a href="#">Privecy Policy</a></li>
                        <li><a href="#">Refund Policy</a></li>
                        <li><a href="#">Billing System</a></li>
                        <li><a href="#">Ticket System</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="single-widget">
                    <h2>About Shopper</h2>
                    <ul class="nav nav-pills nav-stacked">
                        <li><a href="#">Company Information</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">Store Location</a></li>
                        <li><a href="#">Affillate Program</a></li>
                        <li><a href="#">Copyright</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-3 col-sm-offset-1">
                <div class="single-widget">
                    <h2>About Shopper</h2>
                    <form action="#" class="searchform">
                        <input type="text" placeholder="Your email address" />
                        <button type="submit" class="btn btn-default"><i
                                class="fa fa-arrow-circle-o-right"></i></button>
                        <p>Get the most recent updates from <br />our site and be updated your self...</p>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
