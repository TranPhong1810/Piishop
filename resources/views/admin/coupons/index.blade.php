@extends('admin.layouts.app')
@section('title', 'Coupons')
@section('content')
    <div class="card">
        <div class="text-center">
            <h1>Coupons List</h1>
        </div>
        <div>
            <table class="table table-hover">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Value</th>
                    <th>Expery Date</th>
                    <th>Action</th>
                </tr>
                @foreach ($coupon as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->type }}</td>
                        <td>{{ $item->value }}</td>
                        <td>{{ $item->expery_date }}</td>
                        <td>
                            <a class="btn btn-success" href="{{ route('coupons.edit', $item) }}">Edit</a>
                            <button class="btn btn-danger"
                                onclick="if (confirm('Are you sure you want to delete?')) { 
                                    document.getElementById('item-{{ $item->id }}').submit(); }">
                                Delete</button>
                            <form action="{{ route('coupons.destroy', $item) }}" id="item-{{ $item->id }}" method="post">
                                @csrf
                                @method('delete')
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
            {{ $coupon->links() }}
        </div>
    </div>
@endsection
