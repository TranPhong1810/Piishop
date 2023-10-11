@extends('admin.layouts.app')
@section('title', 'Edit Category' . $category->name)
@section('content')
    <div class="card">
        <div class="text-center">
            <h1>Edit Category</h1>
        </div>
        <div>
            <form action="{{ route('categories.update', $category) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="form-group mx-3">
                    <label for="">Name</label>
                    <input type="text" name="name" value="{{ old('name') ?? $category->name }}" class="form-control">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                @if ($category->childrens->count() < 1)
                    <div class="input-group mx-3 mb-3">
                        <label class="input-group-text" for="inputGroupSelect01">Parent Category</label>
                        <select class="form-select" name="parent_id" value="" id="inputGroupSelect01">
                            <option value="">Select Category</option>
                            @foreach ($parentCategories as $item)
                                <option value="{{ $item->id }}"
                                    {{ (old('parent_id') ?? $category->parent_id) == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('gender')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                @endif



                <button type="submit" class="mx-3 btn btn-primary">Add Role</button>
            </form>
        </div>
    </div>
@endsection
