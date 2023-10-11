@extends('admin.layouts.app')
@section('title', 'Create Coupon')
@section('content')
    <div class="card">
        <div class="text-center">
            <h1>Create Coupon</h1>
        </div>
        <div>
            <form action="{{ route('coupons.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="form-group mx-3">
                    <label for="">Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control text-uppercase">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group mx-3 mb-3">
                    <label class="input-group-text" for="inputGroupSelect01">Type</label>
                    <select class="form-select" name="type" value="" id="inputGroupSelect01">
                        <option>Select Type</option>
                        <option value="money">
                            Money</option>
                    </select>
                    @error('type')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mx-3">
                    <label for="">Value</label>
                    <input type="number" name="value" value="{{ old('value') }}" class="form-control">
                    @error('value')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mx-3">
                    <label for="">Expery Date</label>
                    <input type="date" name="expery_date" value="{{ old('expery_date') }}" class="form-control">
                    @error('expery_date')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="mx-3 btn btn-primary">Add Role</button>
            </form>
        </div>
    </div>
@endsection
