@extends('admin.layouts.app')
@section('title', 'Category')
@section('content')
    <div class="card">
        <div class="text-center">
            <h1>Category List</h1>
        </div>
        <div>
            <table class="table table-hover">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Parent Name</th>
                    <th>Action</th>
                </tr>
                @foreach ($categories as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->parent_name }}</td>

                        <td>
                            <a class="btn btn-success" href="{{ route('categories.edit', $item) }}">Edit</a>
                            <button class="btn btn-danger"
                                onclick="if (confirm('Are you sure you want to delete?')) { 
                                    document.getElementById('item-{{ $item->id }}').submit(); }">
                                Delete</button>
                            <form action="{{ route('categories.destroy', $item) }}" id="item-{{ $item->id }}" method="post">
                                @csrf
                                @method('delete')
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
            {{ $categories->links() }}
        </div>
    </div>
@endsection
