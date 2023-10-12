@extends('admin.layouts.app')
@section('title', 'User')
@section('content')
    <div class="card">
        <div class="text-center">
            <h1>Role List</h1>
        </div>
        <div>
            <table class="table table-hover">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
                @foreach ($users as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td><img width="50px"
                                src="{{ $item->images ? asset('uploads/' . $item->images->url) : 'upload/default.jpg' }}"
                                alt=""></td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->phone }}</td>

                        <td>
                            @can('update-user')
                                <a class="btn btn-success" href="{{ route('users.edit', $item) }}">Edit</a>
                            @endcan
                            @can('delete-user')
                                <button class="btn btn-danger"
                                    onclick="if (confirm('Are you sure you want to delete?')) { 
                        document.getElementById('item-{{ $item->id }}').submit(); }">
                                    Delete</button>
                                <form action="{{ route('users.destroy', $item) }}" id="item-{{ $item->id }}" method="post">
                                    @csrf
                                    @method('delete')
                                </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </table>
            {{ $users->links() }}
        </div>
    </div>
@endsection
