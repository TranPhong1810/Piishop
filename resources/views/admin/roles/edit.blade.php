@extends('admin.layouts.app')
@section('title', 'Edit Roles' . $role->name)
@section('content')
    <div class="card">
        <div class="text-center">
            <h1>Edit Role</h1>
        </div>
        <div>
            <form action="{{ route('roles.update', $role) }}" method="post">
                @csrf
                @method('PUT')
                <div class="form-group mx-3">
                    <label for="">Name</label>
                    <input type="text" name="name" value="{{ old('name') ?? $role->name }}" class="form-control">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group  mx-3">
                    <label for="">Display Name</label>
                    <input type="text" name="display_name" value="{{ old('display_name') ?? $role->display_name }}"
                        class="form-control">
                    @error('display_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group  mx-3">
                    <label for="">Group</label>
                    <select class="form-select form-select-lg mb-3" aria-label="Large select example" name="group"
                        value="{{ $role->group }}">
                        <option value="system">System</option>
                        <option value="user">User</option>
                    </select>
                    @error('group')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group  mx-3">
                    <label for="">Permission</label>
                    <div class="row">
                        @foreach ($permissions as $groupName => $permission)
                            <div class="col-5">
                                <h4>{{ $groupName }}</h4>
                                <div>
                                    @foreach ($permission as $item)
                                        <div class="form-check">
                                            <input class="form-check-input" name="permission_ids[]" type="checkbox"
                                                {{ $role->permissions->contains('name', $item->name) ? 'checked' : '' }}
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
