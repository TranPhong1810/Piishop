<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Categories\CreateCategoryRequest;
use App\Http\Requests\Categories\EditCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $category;

    public function __construct(Category $category,)
    {
        $this->category = $category;
    }
    public function index()
    {
        $categories = $this->category->latest('id')->paginate(5);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parentCategory = $this->category->getParents();
        return view('admin.categories.create', compact('parentCategory'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCategoryRequest $request)
    {
        $dataCreate = $request->all();
        $category = $this->category->create($dataCreate);
        toastr()->success('Are you sure you want to proceed ?');
        return redirect()->route('categories.index');
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
        $parentCategories = $this->category->getParents();
        $category = $this->category->with('childrens')->findOrFail($id);
        return view('admin.categories.edit', compact('category', 'parentCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditCategoryRequest $request, string $id)
    {
        $dataUpdate = $request->all();

        $category = $this->category->findOrFail($id);

        $category->update($dataUpdate);

        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        toastr()->error('Have you deleted the '.$category->name);
        return back();
    }
}
