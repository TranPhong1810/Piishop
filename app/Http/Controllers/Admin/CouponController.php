<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Coupons\CreateCouponRequest;
use App\Http\Requests\Coupons\EditCouponRequest;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    protected $coupon;
    public function __construct(Coupon $coupon){
        $this->coupon = $coupon;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coupon = $this->coupon->latest('id')->paginate(5);
        return view('admin.coupons.index',compact('coupon'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.coupons.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCouponRequest $request)
    {
        $dataCreate = $request->all();
        $this->coupon->create($dataCreate);
        toastr()->success('You have successfully added the '.$dataCreate['name']);
        return redirect()->route('coupons.index');
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
        $coupon = $this->coupon->findOrFail($id);
        return view('admin.coupons.edit',compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditCouponRequest $request, Coupon $coupon)
    {
        $dataUpdate = $request->all();
        $coupon->update($dataUpdate);
        toastr()->success('You have successfully update the '.$dataUpdate['name']);
        return redirect()->route('coupons.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        toastr()->error('You have successfully delete the '.$coupon['name']);
        return back();
    }
}
