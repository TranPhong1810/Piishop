@extends('admin.layouts.app')
@section('title', 'Category')
@section('content')
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>All category</h3>
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
                        <div class="text-tiny">Category</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">All category</div>
                </li>
            </ul>
        </div>
        <!-- all-category -->
        <div class="wg-box">
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
                    <form class="form-search">
                        <fieldset class="name">
                            <input type="text" placeholder="Search here..." class="" name="name" tabindex="2"
                                value="" aria-required="true" required="">
                        </fieldset>
                        <div class="button-submit">
                            <button class="" type="submit"><i class="icon-search"></i></button>
                        </div>
                    </form>
                </div>
                <a class="tf-button style-1 w208" href="{{ route('categories.create') }}"><i class="icon-plus"></i>Add new</a>
            </div>
            <div class="wg-table table-all-category">
                <ul class="table-title flex gap20 mb-14">
                    <li>
                        <div class="body-title">Category</div>
                    </li>
                    <li>
                        <div class="body-title">Category</div>
                    </li>
                    <li>
                        <div class="body-title">Action</div>
                    </li>
                </ul>
                <ul class="flex flex-column">
                    @foreach ($categories as $item)
                        <li class="product-item gap14">
                            
                            <div class="flex items-center justify-between gap20 flex-grow">
                                <div class="name">
                                    <h3 class="body-title-2">{{ $item->name }}</h3>
                                </div>
                                <div>
                                    <h3 class="body-title-2">{{ $item->parent_name }}</h3>
                                </div>
                                <div class="list-icon-function">
                                    <div class="item eye">
                                        <i class="icon-eye"></i>
                                    </div>
                                    <div class="item edit">
                                        <a href="{{ route('categories.edit', $item) }}"><i class="icon-edit-3"></i></a>
                                    </div>
                                    <div class="item trash">
                                        <button class="btn btn-danger"
                                            onclick="if (confirm('Are you sure you want to delete?')) { 
                                    document.getElementById('item-{{ $item->id }}').submit(); }">
                                            <i class="icon-trash-2"></i></button>
                                        <form action="{{ route('categories.destroy', $item) }}"
                                            id="item-{{ $item->id }}" method="post">
                                            @csrf
                                            @method('delete')
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="divider"></div>
            <div class="flex items-center justify-between flex-wrap gap10">
                <div class="text-tiny">Showing 10 entries</div>
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
        <!-- /all-category -->
    </div>
@endsection
