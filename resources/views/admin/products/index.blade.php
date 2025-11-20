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
                            <!-- ✅ Thêm id="perPage" -->
                            <select id="perPage">
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                            </select>
                        </div>
                        <div class="text-tiny">entries</div>
                    </div>
                    <div class="select w200">
                        <select id="publish-filter">
                            <option value="">All</option>
                            <option value="1">Publish</option>
                            <option value="0">Unpublish</option>
                        </select>
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
                <!-- ✅ AJAX list container -->
                <ul class="flex flex-column" id="product-list">
                    @foreach ($products as $item)
                        <li class="product-item gap14" id="product-{{ $item->id }}">
                            <div class="image no-bg">
                                <img src="{{ $item->images ? asset('uploads/' . $item->images->url) : asset('upload/default.jpg') }}"
                                    alt="">
                            </div>
                            <div class="flex items-center justify-between gap20 flex-grow">
                                <div class="name">
                                    <a href="{{ route('products.show', $item) }}"
                                        class="body-title-2">{{ $item->name }}</a>
                                </div>
                                <div class="body-text">{{ $item->id }}</div>
                                <div class="body-text">{{ number_format($item->price) }} ₫</div>
                                <div class="body-text">
                                    {{ $item->details->sum('quantity') }}
                                </div>
                                <div class="body-text">{{ $item->sale }}%</div>
                                <div class="body-text">{{ number_format($item->sale_price) }} ₫</div>
                                <div class="body-text">{{ $item->publish }}</div>
                                <div class="list-icon-function">
                                    <div class="item eye">
                                        <a href="{{ route('products.show', $item) }}"><i class="icon-eye"></i></a>
                                    </div>
                                    <div class="item edit">
                                        <a href="{{ route('products.edit', $item) }}"><i class="icon-edit-3"></i></a>
                                    </div>
                                    <div class="item trash">
                                        <button class="delete-btn" data-id="{{ $item->id }}">
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
                <!-- ✅ AJAX pagination container -->
                <ul class="wg-pagination" id="pagination">
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
            const btn = e.target.closest('.delete-btn');
            if (!btn) return;

            const id = btn.getAttribute('data-id');
            if (!id) return;

            Swal.fire({
                title: 'Xác nhận',
                text: 'Bạn có chắc chắn muốn xóa?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/products/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .content,
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => {
                            if (response.status === 204) return {};
                            return response.json();
                        })
                        .then(() => {
                            Swal.fire({
                                title: 'Đã xóa',
                                icon: 'success',
                                timer: 1200,
                                showConfirmButton: false
                            });
                            // Reload list
                            window.searchManager.load();
                        })
                        .catch(err => {
                            console.error('Error:', err);
                            Swal.fire('Lỗi', 'Xóa thất bại', 'error');
                        });
                }
            });
        });
    </script>
@endsection
