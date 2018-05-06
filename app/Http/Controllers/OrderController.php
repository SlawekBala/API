<?php

namespace App\Http\Controllers;

use App\OrderItem;
use Illuminate\Http\Request;
use App\Order;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderMail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = auth()->user()->id;

        $order = Order::where('user_id', $userId)
            ->where('status', 0)
            ->first();
        if ($order) {
            $order = $order->getOrderProducts();
        } else {
            $order = [];
        }

        return $order;

    }

    public function finalOrder(request $request)
    {
        $userId = auth()->user()->id;

        $order = Order::where('user_id', $userId)
                        ->where('status', 0)
                        ->first();

        $order->update([
            'status' => 1
        ]);

        Mail::to($request->user())
            ->send(new OrderMail($request->all(), $order));

        return $order;


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $userId = auth()->user()->id;

        $order = Order::where('user_id', $userId)
            ->where('status', 0)
            ->first();

        if(!$order) {
            $order = new Order();
            $order->user_id = $userId;
            $order->status = 0;
            $order->save();
        }

        $orderItem = OrderItem::where('product_id', $request->product_id)
            ->where('order_id', $order->id)->first();

        if($orderItem){
            $orderItem->update([
                'quantity' => ++$orderItem->quantity
            ]);

        }else {
            $orderItem = new OrderItem();
            $orderItem->product_id = $request->product_id;
            $orderItem->order_id = $order->id;
            $orderItem->quantity = 1;
            $orderItem->save();
        }

        return ['added' => 1];
    }

    public function changeStatus(Request $request, $id)
    {
        $userId = auth()->user()->id;

        $orderItem = OrderItem::find($id);
        $orderItem->update([
        ]);

    }


    public function changeQuantity(Request $request, $id, $add)
    {
        $userId = auth()->user()->id;

        $orderItem = OrderItem::find($id);
        if (!$orderItem) {
            return response()->json([], 404);
        }

        $order = $orderItem->order;
        if ($order->user_id !== $userId) {
            return response()->json([], 401);
        }

        if ($add > 0) {
            $orderItem->update([
                'quantity' => ++$orderItem->quantity
            ]);
        } else {
            if($orderItem->quantity > 1) {
                $orderItem->update([
                    'quantity' => --$orderItem->quantity
                ]);
            }else{
                $orderItem->delete();
            }
        }

        return['status' => 1];

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
