@extends('admin.layouts.app')
@section('title', 'Edit Product ' . $product->name)
@section('content')
    <div class="card">
        <div class="text-center">
            <h1>Edit Product</h1>
        </div>
        <div>
            <form action="{{ route('products.update', $product) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="row mx-3">
                    <div class="input-group col-5 mb-4">
                        <label>Image</label>
                        <div class="input-group mb-3">
                            <input type="file" class="form-control" accept="image/*" name="image" id="image-input"
                                id="inputGroupFile01">
                        </div>
                        @error('image')
                            <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-5">
                        <img src="{{ $product->images ? asset('uploads/' . $product->images->url) : 'upload/default.jpg' }}"
                            class="img-thumbnail" id="show-image" width="200px" alt="">
                    </div>
                </div>

                <div class="form-group mx-3">
                    <label for="">Name</label>
                    <input type="text" name="name" value="{{ old('name') ?? $product->name }}" class="form-control">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group  mx-3">
                    <label for="">Price</label>
                    <input type="text" name="price" value="{{ old('price') ?? $product->price }}" class="form-control">
                    @error('price')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group  mx-3">
                    <label for="">Sale</label>
                    <input type="text" name="sale" value="{{ old('sale') ?? $product->sale }}" class="form-control">
                    @error('sale')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group  mx-3">
                    <label for="">Description</label>
                    <textarea name="description" id="description" cols="30" rows="10">{{ old('description') ?? $product->description }}</textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-group mx-3 mb-3">
                    <label name="group" class="ms-0">Category</label>
                    <select name="category_ids[]" class="form-control" multiple>
                        @foreach ($categories as $item)
                            <option value="{{ $item->id }}"
                                {{ $product->categories->contains('id', $item->id) ? 'selected' : '' }}>
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('category_ids')
                        <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group  mx-3">
                    <input type="hidden" id="inputSize" name='sizes'>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddSizeModal">
                        Add size
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="AddSizeModal" tabindex="-1" aria-labelledby="AddSizeModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="AddSizeModalLabel">Add size</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body" id="AddSizeModalBody">

                                </div>
                                <div class="mt-3">
                                    <button type="button" class="btn  btn-primary btn-add-size">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-submit btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.13.1/underscore-min.js"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>

    <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
    <script>
        $(document).ready(function() {
            $("#image-input").change(function() {
                readURL(this);
            });

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#show-image').attr('src', e.target.result);
                    };
                    console.log(input.files[0]);
                    reader.readAsDataURL(input.files[0]);
                }
            }
        });
    </script>
    <script>
        let sizes = @json($product->details)
    </script>
    <script src="{{ asset('be/js/products/products.js') }}"></script>
@endpush
