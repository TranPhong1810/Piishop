@extends('admin.layouts.app')
@section('title', 'Show Product ' . $product->name)
@section('content')
    <div class="card mx-4">
        <div class="text-center">
            <h1>Show Product</h1>
        </div>
        <div>
            <div class="row mx-3 my-3">
                <div class="col-5">
                    <img src="{{ $product->images ? asset('uploads/' . $product->images->url) : 'upload/default.jpg' }}"
                        class="img-thumbnail" id="show-image" width="200px" alt="">
                </div>
            </div>

            <div class="form-group mx-3">
                <label for="">Name: {{ $product->name }}</label>
            </div>
            <div class="form-group mx-3 ">
                <p>Price: {{ $product->price }}</p>

            </div>

            <div class="form-group mx-3 ">
                <p>Sale: {{ $product->sale }}</p>

            </div>

            <div class="form-group mx-3 form-group">
                <p>Description:</p>
                <div class="row w-100 h-100 mx-1">
                    {!! $product->description !!}
                </div>
            </div>
            <div  class="form-group mx-3 ">
                <p>Size</p>
                @if ($product->details->count() > 0)
                    @foreach ($product->details as $detail)
                        <p>Size: {{ $detail->size }} - quantity: {{ $detail->quantity }}</p>
                    @endforeach
                @else
                    <p> Sản phẩm này chưa nhập size</p>
                @endif
            </div>

        </div>
        <div  class="form-group mx-3 ">
            <p>Category</p>
            @foreach ($product->categories as $item)
                <p>{{ $item->name }}</p>
            @endforeach
        </div>

    </div>
@endsection
