@extends('admin.layouts.app')
@section('title', 'Roles')
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
                    <th>Display Name</th>
                    <th>Action</th>
                </tr>
                @foreach ($roles as $role)
                    <tr>
                        <td>{{ $role->id }}</td>
                        <td>{{ $role->name }}</td>
                        <td>{{ $role->display_name }}</td>
                        <td>
                            @can('update-role')
                                <a class="btn btn-success" href="{{ route('roles.edit', $item) }}">Edit</a>
                            @endcan
                            @can('delete-role')
                                <button class="btn btn-danger"
                                    onclick="if (confirm('Are you sure you want to delete?')) { 
                        document.getElementById('item-{{ $item->id }}').submit(); }">
                                    Delete</button>
                                <form action="{{ route('roles.destroy', $item) }}" id="item-{{ $item->id }}" method="post">
                                    @csrf
                                    @method('delete')
                                </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </table>
            {{ $roles->links() }}
        </div>
    </div>
@endsection
