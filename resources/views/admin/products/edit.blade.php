@extends('admin.layouts.app')
@section('title', 'Edit Product ' . $product->name)
@section('content')
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Add Product</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="index.html">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <a href="#">
                        <div class="text-tiny">Ecommerce</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Add product</div>
                </li>
            </ul>
        </div>
        <!-- form-add-product -->
        <form class="tf-section-2 form-add-product" action="{{ route('products.update', $product) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="wg-box">
                <fieldset class="name">
                    <div class="body-title mb-10">Product name <span class="tf-color-1">*</span></div>
                    <input class="mb-10" type="text" placeholder="Enter product name" name="name" tabindex="0"
                        value="{{ old('name') ?? $product->name }}" aria-required="true" required="">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </fieldset>
                <div class="gap22 cols">
                    <fieldset class="category">
                        <div class="body-title mb-10">Category <span class="tf-color-1">*</span></div>
                        <div class="select">
                            <select name="category_ids[]" class="">
                                @foreach ($categories as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $product->categories->contains('id', $item->id) ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('category_ids')
                            <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </fieldset>
                    <fieldset class="male">
                        <div class="body-title mb-10">Status <span class="tf-color-1">*</span></div>
                        <div class="select">
                            <select name="publish">
                                <option value="1" {{ old('publish', $product->publish) == 1 ? 'selected' : '' }}>
                                    Publish</option>
                                <option value="0" {{ old('publish', $product->publish) == 0 ? 'selected' : '' }}>
                                    Unpublish</option>
                            </select>
                        </div>
                        @error('publish')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </fieldset>
                </div>
                <fieldset class="brand">
                    <div class="body-title mb-10">Price<span class="tf-color-1">*</span></div>
                    <input class="mb-10" type="text" placeholder="Enter product sale" name="price" tabindex="0"
                        value="{{ old('price') ?? $product->sale }}" aria-required="true" required="">
                </fieldset>
                <fieldset class="brand">
                    <div class="body-title mb-10">Sale<span class="tf-color-1">*</span></div>
                    <input class="mb-10" type="text" placeholder="Enter product sale" name="sale" tabindex="0"
                        value="{{ old('sale') ?? $product->sale }}" aria-required="true" required="">
                </fieldset>
                <fieldset class="description">
                    <div class="body-title mb-10">Description <span class="tf-color-1">*</span></div>
                    <textarea class="mb-10" name="description" placeholder="Description" tabindex="0" aria-required="true"
                        required="">{{ $product->description }}</textarea>
                    <div class="text-tiny">Do not exceed 100 characters when entering the product name.</div>
                </fieldset>
            </div>
            <div class="wg-box">
                <fieldset>
                    <div class="body-title mb-10">Upload images</div>
                    <div class="upload-image mb-16" id="upLoadContainer">
                        <img src="{{ $product->images ? asset('uploads/' . $product->images->url) : 'upload/default.jpg' }}"
                            width="200px">
                        <div class="item up-load">
                            <label class="uploadfile" for="myFile">
                                <span class="icon"><i class="icon-upload-cloud"></i></span>
                                <span class="text-tiny">
                                    Drop your images here or select <span class="tf-color">click to browse</span>
                                </span>
                                <input type="file" id="myFile" accept="image/*" name="image">
                            </label>
                        </div>
                    </div>
                </fieldset>

                <div class="cols gap10">
                    <div class="">
                        <input type="hidden" id="inputSize" name='sizes'>
                        <!-- Button trigger modal -->
                        <button type="button" class="tf-button w-full" data-bs-toggle="modal"
                            data-bs-target="#AddSizeModal">
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
                </div>
                <div class="cols gap10">
                    <button class="tf-button w-full" type="submit">Edit product</button>
                </div>
            </div>
        </form>
        <!-- /form-add-product -->
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.13.1/underscore-min.js"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>

    <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
    <script>
        const fileInput = document.getElementById('myFile');
        const container = document.getElementById('upLoadContainer');
        let oldImage = container.querySelector('img'); // ảnh cũ

        fileInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (!file) return;

            if (!file.type.startsWith("image/")) {
                alert('Vui lòng chọn file ảnh.');
                fileInput.value = '';
                return;
            }

            // Xóa preview cũ (ảnh cũ hoặc preview cũ)
            const prev = container.querySelector('.item.preview');
            if (prev) prev.remove();
            if (oldImage) oldImage.style.display = 'none'; // ẩn ảnh cũ

            const reader = new FileReader();
            reader.onload = function(e) {
                const newItem = document.createElement('div');
                newItem.classList.add('item', 'preview');
                newItem.style.position = "relative";

                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.width = "100%";

                const removeBtn = document.createElement('span');
                removeBtn.innerHTML = '&times;';
                removeBtn.style.position = "absolute";
                removeBtn.style.top = "2px";
                removeBtn.style.right = "5px";
                removeBtn.style.color = "red";
                removeBtn.style.fontSize = "18px";
                removeBtn.style.cursor = "pointer";

                removeBtn.addEventListener('click', function() {
                    newItem.remove();
                    fileInput.value = '';
                    if (oldImage) oldImage.style.display = ''; // hiện lại ảnh cũ
                });

                newItem.appendChild(img);
                newItem.appendChild(removeBtn);
                const uploadBox = container.querySelector('.item.up-load');
                container.insertBefore(newItem, uploadBox);
            };
            reader.readAsDataURL(file);
        });
    </script>
    <script>
        let sizes = @json($product->details)
    </script>
    <style>
        /* Modal content */
        #AddSizeModal .modal-content {
            border-radius: 12px;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        /* Modal header */
        #AddSizeModal .modal-header {
            border-bottom: none;
            padding-bottom: 0;
        }

        #AddSizeModal .modal-title {
            font-weight: 700;
            font-size: 20px;
            color: #333;
        }

        /* Modal body */
        #AddSizeModalBody {
            max-height: 350px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 12px;
            padding: 10px 0;
        }

        /* Item size */
        .product-item-size {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 8px;
            background-color: #f4f6f9;
            border: 1px solid #e0e0e0;
        }

        /* Input size & quantity */
        .product-item-size .form-control {
            padding: 6px 10px;
            font-size: 14px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        /* Nút xóa */
        .product-item-size .btn-remove-size {
            padding: 4px 10px;
            font-size: 13px;
            border-radius: 6px;
        }

        /* Nút Add size */
        #AddSizeModal .btn-add-size {
            width: 100%;
            background-color: #4a90e2;
            border: none;
            color: white;
            font-weight: 600;
            padding: 10px;
            border-radius: 8px;
            transition: background 0.2s ease-in-out;
        }

        #AddSizeModal .btn-add-size:hover {
            background-color: #357ab8;
        }

        /* Scrollbar đẹp */
        #AddSizeModalBody::-webkit-scrollbar {
            width: 6px;
        }

        #AddSizeModalBody::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.2);
            border-radius: 3px;
        }
    </style>
    <script src="{{ asset('backend/js/products.js') }}"></script>
@endpush
