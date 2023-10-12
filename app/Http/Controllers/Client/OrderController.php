<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $order;
    public function __construct(Order $order)
    {
        $this->order = $order;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $order = $this->order->getWithPaginateBy(auth()->user()->id);
        return view('client.orders.index', compact('order'));
    }

    public function cancel($id)
    {
        $order = $this->order->find($id);

        if (!$order) {
            // Đơn hàng không tồn tại, bạn có thể xử lý thông báo lỗi hoặc hướng dẫn người dùng đúng cách.
            toastr()->error('Order not found');
            return redirect()->route('client.orders.index');
        }

        // Tiếp tục xử lý việc hủy đơn hàng
        $order->update(['status' => 'cancel']);
        toastr()->error('Cancel Success');
        return redirect()->route('client.orders.index', compact('order'));
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
        //
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
}
