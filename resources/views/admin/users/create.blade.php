@extends('admin.layouts.app')
@section('title', 'Create User')
@section('content')
    <div class="card">
        <div class="text-center">
            <h1>Create User</h1>
        </div>
        <div>
            <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
                @csrf
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
                        <img src="..." class="img-thumbnail" id="show-image" width="200px" alt="">
                    </div>
                </div>

                <div class="form-group mx-3">
                    <label for="">Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group  mx-3">
                    <label for=""> Email</label>
                    <input type="text" name="email" value="{{ old('email') }}" class="form-control">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group  mx-3">
                    <label for=""> Phone</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="form-control">
                    @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group  mx-3">
                    <label for="">Password</label>
                    <input type="password" name="password" class="form-control">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-group mx-3 mb-3">
                    <label class="input-group-text" for="inputGroupSelect01">Gender</label>
                    <select class="form-select" name="gender" id="inputGroupSelect01">
                        <option value="male">Male</option>
                        <option value="fe-male">Female</option>
                    </select>
                    @error('gender')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group  mx-3">
                    <label for=""> Address</label>
                    <textarea type="text" name="address" class="form-control"> {{ old('address') }}</textarea>
                    @error('address')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group  mx-3">
                    <label for="">Roles</label>
                    <div class="row">
                        @foreach ($roles as $groupName => $role)
                            <div class="col-5">
                                <h4>{{ $groupName }}</h4>
                                <div>
                                    @foreach ($role as $item)
                                        <div class="form-check">
                                            <input class="form-check-input" name="role_ids[]" type="checkbox"
                                                value="{{ $item->id }}" id="flexCheckIndeterminate">
                                            <label class="form-check-label" for="flexCheckIndeterminate">
                                                {{ $item->display_name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <button type="submit" class="mx-3 btn btn-primary">Add Role</button>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
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
@endpush
