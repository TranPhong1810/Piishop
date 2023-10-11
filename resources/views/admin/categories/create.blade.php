@extends('admin.layouts.app')
@section('title', 'Create Category')
@section('content')
    <div class="card">
        <div class="text-center">
            <h1>Create Category</h1>
        </div>
        <div>
            <form action="{{ route('categories.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="form-group mx-3">
                    <label for="">Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-group mx-3 mb-3">
                    <label class="input-group-text" for="inputGroupSelect01">Parent Category</label>
                    <select class="form-select" name="parent_id" value="" id="inputGroupSelect01">
                        <option value="">Select Category</option>
                        @foreach ($parentCategory as $item)
                            <option value="{{ $item->id }}" {{ old('parent_id') == $item->id ? 'selected' : ''}}>{{ $item->name }}</option>
                        @endforeach
                    </select>
                    @error('gender')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                <button type="submit" class="mx-3 btn btn-primary">Add Role</button>
            </form>
        </div>
    </div>
@endsection
