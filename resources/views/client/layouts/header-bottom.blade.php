<div class="container">
    <div class="row">
        <div class="col-sm-9">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="mainmenu pull-left">
                <ul class="nav navbar-nav collapse navbar-collapse">
                    <li><a href="{{route('home')}}" class="active">Home</a></li>
                    <li class="dropdown"><a href="#">Shop<i class="fa fa-angle-down"></i></a>
                        <ul role="menu" class="sub-menu">
                            @foreach ($categories as $item)
                                <li>
                                    <a
                                        href="{{ route('client.product.index', ['category_id' => $item->id]) }}">{{$item->name}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <li><a href="{{route('client.orders.index')}}">Order</a></li>
                    <li><a href="contact-us.html">Contact</a></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="search_box pull-right">
                <input type="text" placeholder="Search" />
            </div>
        </div>
    </div>
</div>
