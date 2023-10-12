@extends('admin.layouts.app')
@section('title', 'Order')
@section('content')
    <div class="card">
        <div class="text-center">
            <h1>Order List</h1>
        </div>
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
                            <td>
                                <div class="input-group input-group-static mb-4">
                                    <select name="status" class="form-control select-status"
                                        data-action="{{ route('admin.orders.update_status', $item->id) }}">

                                        @foreach (config('orders.status') as $status)
                                            <option value="{{ $status }}"
                                                {{ $status == $item->status ? 'selected' : '' }}>{{ $status }}
                                            </option>
                                        @endforeach
                                    </select>

                            </td>
                            <td>{{ $item->total }}<strong>đ</strong></td>

                            <td>{{ $item->ship }}<strong>đ</strong></td>
                            <td>{{ $item->customer_name }}</td>
                            <td>{{ $item->customer_email }}</td>

                            <td>{{ $item->customer_address }}</td>
                            <td>{{ $item->note }}</td>
                            <td>{{ $item->payment }}</td>
                        </tr>
                    @endforeach
                @endif
            </table>
            {{ $order->links() }}
        </div>
    </div>
@endsection
@push('order')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script src="{{asset('be/js/base/base.js')}}"></script>
@endpush
