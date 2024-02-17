<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Shipping;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
use Session;

class CheckoutController extends Controller
{
    public function Checkout(Request $request)
    {             
        $ProductItems  = $request->input('ProductItems');
        $processData = $this->ProcessData($ProductItems);
    }
    private function ProcessData($ProductItems){
        $processData = array_merge($ProductItems);
        return $processData;
    }
    public function StoreShipping(Request $request)
    {
            $request->validate([
                'name' => 'required',
                'email' => 'required',
                'number' => 'required',
                'division' => 'required',
                'city' => 'required',
                'address' => 'required',
            ]);
            $userId = Auth::id();
            $shippingType = 'user';
            $data = [
                'user_id' => $userId,
                'shipping_type' => $shippingType,
                'name' => $request->name,
                'email' => $request->email,
                'number' => $request->number,
                'division' => $request->division,
                'city' => $request->city,
                'address' => $request->address,
            ];
    
            $shipping = Shipping::create($data);
            Session::put('shippingId', $shipping->id);
            Session::put('Id', $shipping->id);
    
            return redirect()->route('payment');
    }

    public function payment()
    {
        $id =  Session::get('Id');
        Session()->forget('Id');
        if($id){
            $userId = Auth::id();
            $cartItems = Cart::where('user_id', $userId)->where('cart_type', 'user')->get();
            return view('payment', compact('cartItems',));
        }
        else{
            return back();
        }
    }

    public function orderPlace(Request $request)
    {
        $paymentData = [
            'payment_method' => 'bkash',
            'status' => 'pending',
        ];
        $payment = Payment::create($paymentData);

        $customerId = Auth::id();
        $orderData = [
            'customer_id' => $customerId,
            'shipping_id' => Session::get('shippingId'),
            'payment_id' => $payment->id,
            'order_type' => 'user',
            'status' => 'pending',
            'total' => $request->total,
        ];
        $order = Order::create($orderData); // Changed variable name to $order

        $userId = Auth::id();
        $cartItems = Cart::where('cart_type', 'user')->where('user_id', $userId)->get();
        foreach ($cartItems as $cartItem) {
            $orderDetailData = [ // Corrected variable name
                'order_id' => $order->id, // Changed variable name to $order
                'product_id' => $cartItem->id,
                'product_name' => $cartItem->product_name,
                'product_price' => $cartItem->product_price,
                'quantity' => $cartItem->quantity,
                'product_img' => $cartItem->product_img,
            ];
            OrderDetail::create($orderDetailData); // Corrected model name
        }
        if (!isset($request->total)) {
            Session::forget('shippingId');
        }
        // Redirect to a confirmation page or any other relevant page
        return redirect()->route('order.confirmation');
    }

    public function OrderConfirmation(){
        return 'Successfully OrderConfirmation';
    }
}
