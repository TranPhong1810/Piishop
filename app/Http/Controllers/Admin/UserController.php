<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\CreateUserRequest;
use App\Http\Requests\Users\EditUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $user;
    protected $role;

    public function __construct(User $user, Role $role)
    {
        $this->user = $user;
        $this->role = $role;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = $this->user->latest('id')->paginate(5);
        return view('admin.users.index', compact('users'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = $this->role->all()->groupBy('group');
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request)
    {
        $dataCreate = $request->all();
        $dataCreate['password'] = Hash::make($request->password);
        $dataImage['image'] = $this->user->saveImage($request);
        $user = $this->user->create($dataCreate);
        $user->images()->create(['url' => $dataImage['image']]);
        $user->roles()->attach($dataCreate['role_ids']);
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = $this->user->findOrFail($id)->load('roles');
        $roles = $this->role->all()->groupBy('group');
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditUserRequest $request, string $id)
    {
        $user = $this->user->findOrFail($id)->load('roles');
        $dataUpdate = $request->except('password');
        if ($request->has('password')) {
            $dataUpdate['password'] = Hash::make($request->password);
        }
        
        $currentImage = $user->images ? $user->images->url : "";
    
        // Kiểm tra và xóa ảnh cũ nếu tồn tại
        if ($currentImage) {
            $this->user->deleteImage($currentImage);
        }
    
        // Thêm ảnh mới và cập nhật thông tin người dùng
        $dataUpdate['image'] = $this->user->UpdateImage($request, $currentImage);
        $user->update($dataUpdate);
    
        // Thêm ảnh mới
        $user->images()->create(['url' => $dataUpdate['image']]);
    
        // Cập nhật vai trò
        $user->roles()->sync($dataUpdate['role_ids'] ?? []);
    
        return redirect()->route('users.index');
        $dataUpdate = $request->except('password');
        if ($request->password) {
            $dataUpdate['password'] = Hash::make($request->password);
        }
        $currentImage = $user->images ? $user->images->url : "";
        // Kiểm tra và xóa ảnh cũ nếu tồn tại
        if ($currentImage) {
            $this->user->deleteImage($currentImage);
        }
        $dataUpdate['image'] = $this->user->UpdateImage($request, $currentImage);

        $user->update($dataUpdate);
        $user->images()->delete();
        $user->images()->updateOrCreate(['url' => $dataUpdate['image']]);
        $user->roles()->sync($dataUpdate['role_ids'] ?? []);
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = $this->user->findOrFail($id)->load('roles');
        $user->images()->delete();
        $imageName = $user->images ? $user->images->url : "";
        $this->user->deleteImage($imageName);
        $user->delete();
        return back();

    }
}
