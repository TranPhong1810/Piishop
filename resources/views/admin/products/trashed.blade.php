@extends('admin.layouts.app')
@section('title', 'Product')
@section('content')
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Product List</h3>
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
                    <div class="text-tiny">Product List</div>
                </li>
            </ul>
        </div>
        <!-- product-list -->
        <div class="wg-box">
            <div class="title-box">
                <i class="icon-coffee"></i>
                <div class="body-text">Tip search by Product ID: Each product is provided with a unique ID, which you can
                    rely on to find the exact product you need.</div>
            </div>
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                    <div class="show">
                        <div class="text-tiny">Showing</div>
                        <div class="select">
                            <select class="">
                                <option>10</option>
                                <option>20</option>
                                <option>30</option>
                            </select>
                        </div>
                        <div class="text-tiny">entries</div>
                    </div>
                    <form class="form-search" id="search-form" onsubmit="return false;">
                        <fieldset class="name">
                            <!-- ✅ Thêm id="search" -->
                            <input type="text" id="search" placeholder="Search...">
                        </fieldset>
                        <div class="button-submit">
                            <button type="submit"><i class="icon-search"></i></button>
                        </div>
                    </form>
                </div>
                <a class="tf-button style-1 w208" href="{{ route('products.create') }}"><i class="icon-plus"></i>Add new</a>
            </div>
            <div class="wg-table table-product-list">
                <ul class="table-title flex gap20 mb-14">
                    <li>
                        <div class="body-title">Product</div>
                    </li>
                    <li>
                        <div class="body-title">Product ID</div>
                    </li>
                    <li>
                        <div class="body-title">Price</div>
                    </li>
                    <li>
                        <div class="body-title">Quantity</div>
                    </li>
                    <li>
                        <div class="body-title">Sale</div>
                    </li>
                    <li>
                        <div class="body-title">Sale Price</div>
                    </li>
                    <li>
                        <div class="body-title">Status</div>
                    </li>
                    <li>
                        <div class="body-title">Action</div>
                    </li>
                </ul>
                <ul class="flex flex-column" id="product-list-trashed">
                    @foreach ($products as $item)
                        <li class="product-item gap14" id="product-{{ $item->id }}">
                            <div class="image no-bg">
                                <img src="{{ $item->images ? asset('uploads/' . $item->images->url) : 'upload/default.jpg' }}"
                                    alt="">
                            </div>
                            <div class="flex items-center justify-between gap20 flex-grow">
                                <div class="name">
                                    <a href="product-list.html" class="body-title-2">{{ $item->name }}</a>
                                </div>
                                <div class="body-text">{{ $item->id }}</div>
                                <div class="body-text">{{ number_format($item->price) }} ₫</div>
                                <div class="body-text">
                                    {{ $item->details->sum('quantity') }}
                                </div>
                                <div class="body-text">{{ $item->sale }}%</div>
                                <div class="body-text">{{ number_format($item->sale_price) }} ₫</div>

                                <div class="list-icon-function">
                                    <div class="item restore">
                                        <button class="btn btn-success restore-btn" data-id="{{ $item->id }}">
                                            Restore
                                        </button>
                                    </div>
                                    <div class="item force-delete">
                                        <button class="btn btn-danger force-delete-btn" data-id="{{ $item->id }}">
                                            <i class="icon-trash-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="divider"></div>
            <div class="flex items-center justify-between flex-wrap gap10">
                <div class="text-tiny">Showing <span id="item-count">{{ count($products) }}</span> entries</div>
                <ul class="wg-pagination">
                    <li>
                        <a href="#"><i class="icon-chevron-left"></i></a>
                    </li>
                    <li>
                        <a href="#">1</a>
                    </li>
                    <li class="active">
                        <a href="#">2</a>
                    </li>
                    <li>
                        <a href="#">3</a>
                    </li>
                    <li>
                        <a href="#"><i class="icon-chevron-right"></i></a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /product-list -->
    </div>
    <script>
        document.addEventListener('click', function(e) {
            // Restore
            const restoreBtn = e.target.closest('.restore-btn');
            if (restoreBtn) {
                const id = restoreBtn.getAttribute('data-id');
                fetch(`/products/${id}/restore`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire({
                            title: data.message,
                            icon: 'success',
                            timer: 1200,
                            showConfirmButton: false
                        });
                        const row = document.getElementById('product-' + id);
                        if (row) row.remove();
                    });
            }

            // Force Delete
            const forceDeleteBtn = e.target.closest('.force-delete-btn');
            if (forceDeleteBtn) {
                const id = forceDeleteBtn.getAttribute('data-id');
                fetch(`/products/${id}/force-delete`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire({
                            title: data.message,
                            icon: 'success',
                            timer: 1200,
                            showConfirmButton: false
                        });
                        const row = document.getElementById('product-' + id);
                        if (row) row.remove();
                    });
            }
        })
    </script>


@endsection
