@extends('client.layouts.app')
@section('title', 'Cart')
@section('content')
    <div class="col-sm-9 padding-right">
        <div class="col">
            <div>
                <table class="table table-hover">
                    <tr>
                        <th>#</th>

                        <th>status</th>
                        <th>total</th>
                        <th>ship</th>
                        <th>customer_name</th>
                        <th>customer_email</th>
                        <th>customer_address</th>
                        <th>note</th>
                        <th>payment</th>


                    </tr>
                    @if ($order)
                        @foreach ($order as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->status }}</td>
                                <td>{{ $item->total }}<strong>đ</strong></td>

                                <td>{{ $item->ship }}<strong>đ</strong></td>
                                <td>{{ $item->customer_name }}</td>
                                <td>{{ $item->customer_email }}</td>

                                <td>{{ $item->customer_address }}</td>
                                <td>{{ $item->note }}</td>
                                <td>{{ $item->payment }}</td>
                                <td>
                                    @if ($item->status == "Pending")
                                    
                                        <button class="btn btn-danger"
                                            onclick="if (confirm('Are you sure you want to cancel?')) { 
                                        document.getElementById('item-{{ $item->id }}').submit(); }">
                                            Cancel</button>
                                        <form action="{{ route('client.orders.cancel', $item) }}"
                                            id="item-{{ $item->id }}" method="post">
                                            @csrf
                                            @method('delete')
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </table>
                {{ $order->links() }}
            </div>
        </div>
    </div>
@endsection
