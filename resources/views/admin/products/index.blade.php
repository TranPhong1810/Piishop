@extends('admin.layouts.app')
@section('title', 'Product')
@section('content')
    <div class="card">
        <div class="text-center">
            <h1>Product </h1>
        </div>
        <div>
            <table class="table table-hover">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Sale</th>
                    <th>Action</th>
                </tr>
                @foreach ($products as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td><img width="50px"
                                src="{{ $item->images ? asset('uploads/' . $item->images->url) : 'upload/default.jpg' }}"
                                alt=""></td>
                        <td>{{ $item->price }}</td>
                        <td>{{ $item->sale }}</td>

                        <td>
                            @can('update-product')
                                <a class="btn btn-success" href="{{ route('products.edit', $item) }}">Edit</a>
                            @endcan
                            @can('delete-product')
                                <button class="btn btn-danger"
                                    onclick="if (confirm('Are you sure you want to delete?')) { 
                        document.getElementById('item-{{ $item->id }}').submit(); }">
                                    Delete</button>
                                <form action="{{ route('products.destroy', $item) }}" id="item-{{ $item->id }}"
                                    method="post">
                                    @csrf
                                    @method('delete')
                                </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </table>
            {{ $products->links() }}
        </div>
    </div>
@endsection
