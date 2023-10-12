<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\CreateOrderRequest;
use App\Http\Resources\Cart\CartResource;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CartController extends Controller
{
    protected $cart;
    protected $product;
    protected $cartProduct;
    protected $coupon;
    protected $order;

    public function __construct(Product $product, Cart $cart, CartProduct $cartProduct, Coupon $coupon, Order $order)
    {
        $this->cart = $cart;
        $this->product = $product;
        $this->cartProduct = $cartProduct;
        $this->coupon = $coupon;
        $this->order = $order;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cart = $this->cart->firstOrCreateBy(auth()->user()->id)->load('product');
        return view('client.carts.index', compact('cart'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->product_size) {
            $product = $this->product->findOrFail($request->product_id);
            $cart = $this->cart->firstOrCreateBy(auth()->user()->id);
            $cartProduct = $this->cartProduct->getBy($cart->id, $product->id, $request->product_size);
            if ($cartProduct) {
                $quantity = $cartProduct->product_quantity;
                $cartProduct->update(['product_quantity' => ($quantity + $request->product_quantity)]);
            } else {
                $dataCreate['cart_id'] = $cart->id;
                $dataCreate['product_size'] = $request->product_size;
                $dataCreate['product_quantity'] = $request->product_quantity ?? 1;
                $dataCreate['product_price'] = $product->price;
                $dataCreate['product_id'] = $request->product_id;
                $this->cartProduct->create($dataCreate);
            }
            toastr()->success('Add Success ' . $product['name']);
            return back();
        } else {
            toastr()->error('You have not selected a size yet');
            return back();
        }
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function removeQuantityProduct($id)
    {
        $cartProduct =  $this->cartProduct->find($id);
        $cartProduct->delete();
        $cart =  $cartProduct->cart;
        return response()->json([
            'product_cart_id' => $id,
            'cart' => new CartResource($cart),
        ], Response::HTTP_OK);
    }



    public function updateQuantityProduct(Request $request, $id)
    {
        $cartProduct =  $this->cartProduct->find($id);
        $dataUpdate = $request->all();
        if ($dataUpdate['product_quantity'] < 1) {
            $cartProduct->delete();
        } else {
            $cartProduct->update($dataUpdate);
        }

        $cart =  $cartProduct->cart;

        return response()->json([
            'product_cart_id' => $id,
            'cart' => new CartResource($cart),
            'remove_product' => $dataUpdate['product_quantity'] < 1,
            'cart_product_price' => $cartProduct->total_price
        ], Response::HTTP_OK);
    }

    public function applyCoupon(Request $request)
    {
        $name = $request->input('coupon_code');
        $coupon = $this->coupon->firstWithExperyDate($name, auth()->user()->id);
        if ($coupon) {
            toastr()->success('Apply coupon code successfully');
            session(['coupon_id' => $coupon->id]);
            session(['discount_amount_price' => $coupon->value]);
            session(['coupon_code' => $coupon->name]);
        } else {
            toastr()->error('Apply an existing coupon code');
            session()->forget(['coupon_id', 'discount_amount_price', 'coupon_code']);
        }
        return redirect()->route('client.cart.index');
    }
    public function checkout()
    {
        $cart = $this->cart->firstOrCreate(['user_id' => auth()->user()->id]);
        $cart->load('product');
        return view('client.carts.checkout', compact('cart'));
    }
    public function processCheckout(CreateOrderRequest $request)
    {

        $dataCreate = $request->all();
        // dd($dataCreate);
        $dataCreate['user_id'] = auth()->user()->id;
        // dd($dataCreate['user_id']);
        $dataCreate['user_id'] = intval($request->input('user_id'));
        $dataCreate['status'] = 'pending';
        $this->order->create($dataCreate);
        $couponID = Session::get('coupon_id');
        if ($couponID) {
            $coupon =  $this->coupon->find(Session::get('coupon_id'));
            if ($coupon) {
                $coupon->users()->attach(auth()->user()->id, ['value' => $coupon->value]);
            }
        }
        $cart = $this->cart->firstOrCreateBy(auth()->user()->id);
        $cart->product()->delete();
        Session::forget(['coupon_id', 'discount_amount_price', 'coupon_code']);
    }
}
