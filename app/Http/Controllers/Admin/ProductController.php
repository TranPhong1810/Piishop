<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\EditProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $product;
    protected $category;
    public function __construct(Product $product, Category $category)
    {
        $this->product = $product;
        $this->category = $category;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = trim($request->get('q', ''));
        $perPage = (int)$request->get('per_page', 10);
        $page = (int)$request->get('page', 1);

        $query = Product::query();

        if ($q !== '') {
            $query->where(function ($q2) use ($q) {
                $q2->where('name', 'like', "%{$q}%")
                    ->orWhere('id', 'like', "%{$q}%");
            });
        }
        if ($request->has('publish')) {
            $query->where('publish', (int)$request->get('publish'));
        }
        $products = $query->latest('id')->paginate($perPage, ['*'], 'page', $page);

        if ($request->ajax()) {
            $items = collect($products->items()); // chuyển về Collection
            return response()->json([
                'data' => $items->map(function ($p) {
                    return [
                        'id' => $p->id,
                        'name' => $p->name,
                        'price' => $p->price,
                        'sale' => $p->sale,
                        'sale_price' => $p->sale_price,
                        'publish' => $p->publish,
                        'quantity' => $p->details->sum('quantity') ?? 0,
                        'image_url' => $p->images
                            ? asset('uploads/' . $p->images->url)
                            : asset('upload/default.jpg')
                    ];
                })->toArray(),
                'meta' => [
                    'current_page' => $products->currentPage(),
                    'last_page' => $products->lastPage(),
                    'per_page' => $products->perPage(),
                    'total' => $products->total(),
                ]
            ]);
        }

        // Regular page view
        return view('admin.products.index', compact('products', 'q'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::select('id', 'name')->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProductRequest $request)
    {
        $dataCreate = $request->except('sizes');
        $sizes = $request->sizes ? json_decode($request->sizes) : [];
        $product = Product::create($dataCreate);
        $dataCreate['image'] = $this->product->saveImage($request);
        $product->images()->create(['url' => $dataCreate['image']]);
        $product->assignCategory($dataCreate['category_ids']);
        $sizeArray = [];
        foreach ($sizes as $size) {
            $sizeArray[] = ['size' => $size->size, 'quantity' => $size->quantity, 'product_id' => $product->id];
        }
        ProductDetail::insert($sizeArray);
        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = $this->product->with('details', 'categories', 'images')->findOrFail($id);
        // dd($product);
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = $this->product->with('details', 'categories')->findOrFail($id);
        $categories = Category::select('id', 'name')->get();
        return view('admin.products.edit', compact('categories', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditProductRequest $request, string $id)
    {
        $product = $this->product->findOrFail($id);
        $dataUpdate = $request->except('sizes');

        // Xử lý ảnh
        if ($request->hasFile('image')) {
            $imageName = $this->product->UpdateImage($request, $product->images ? $product->images->url : null);

            if ($product->images) {
                // Cập nhật ảnh cũ
                $product->images->update(['url' => $imageName]);
            } else {
                // Nếu chưa có record images
                $product->images()->create(['url' => $imageName]);
            }
        }

        $product->update($dataUpdate);

        if (isset($dataUpdate['category_ids'])) {
            $product->categories()->sync($dataUpdate['category_ids']);
        }

        $sizes = $request->sizes ? json_decode($request->sizes, true) : [];

        if (!empty($sizes)) {
            // Xóa size cũ
            $product->details()->delete();

            // Insert size mới
            $sizeArray = [];
            foreach ($sizes as $size) {
                $sizeArray[] = [
                    'size' => $size['size'],
                    'quantity' => $size['quantity'],
                    'product_id' => $product->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            ProductDetail::insert($sizeArray);
        }

        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(string $id)
    {
        $product = $this->product->findOrFail($id);
        $product->delete();
        $product->details()->delete();
        $this->product->deleteImage($product);
        return back();
    }


    public function indexSoftDelete(Request $request)
    {
        $q = trim($request->get('q', ''));
        $perPage = (int)$request->get('per_page', 10);
        $page = (int)$request->get('page', 1);

        $query = Product::onlyTrashed();

        if ($q !== '') {
            $query->where(function ($q2) use ($q) {
                $q2->where('name', 'like', "%{$q}%")
                    ->orWhere('id', 'like', "%{$q}%");
            });
        }

        $products = $query->latest('id')->paginate($perPage, ['*'], 'page', $page);

        if ($request->ajax()) {
            $items = collect($products->items()); // chuyển về Collection
            return response()->json([
                'data' => $items->map(function ($p) {
                    return [
                        'id' => $p->id,
                        'name' => $p->name,
                        'price' => $p->price,
                        'sale' => $p->sale,
                        'sale_price' => $p->sale_price,
                        'publish' => $p->publish,
                        'quantity' => $p->details->sum('quantity') ?? 0,
                        'image_url' => $p->images
                            ? asset('uploads/' . $p->images->url)
                            : asset('upload/default.jpg')
                    ];
                })->toArray(),
                'meta' => [
                    'current_page' => $products->currentPage(),
                    'last_page' => $products->lastPage(),
                    'per_page' => $products->perPage(),
                    'total' => $products->total(),
                ]
            ]);
        }

        // Regular page view
        return view('admin.products.trashed', compact('products', 'q'));
    }

    public function restore(string $id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();

        // Trả về JSON để JS xử lý
        return response()->json([
            'success' => true,
            'message' => 'Sản phẩm đã được khôi phục'
        ]);
    }

    public function forceDelete(string $id)
    {
        $product = Product::withTrashed()->findOrFail($id);

        // Xóa chi tiết liên quan
        $product->details()->delete();

        // Xóa file ảnh nếu tồn tại trong storage/app/public
        if ($product->images) {
            $imagePath = storage_path('app/public/' . $product->images->url); // chỉnh theo folder lưu ảnh
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            // Xóa record ảnh khỏi DB
            $product->images()->delete();
        }

        // Xóa sản phẩm khỏi DB
        $product->forceDelete();

        return response()->json(['message' => 'Đã xóa vĩnh viễn']);
    }
}
