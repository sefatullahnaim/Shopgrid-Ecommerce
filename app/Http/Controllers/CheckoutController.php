<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Cart;
use Session;
use App\Http\Controllers\SslCommerzPaymentController;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('website.checkout.index');
    }


    public function newOrder(Request $request)
    {
        if (Session::get('customer_id'))
        {
            $customer = Customer::find( Session::get('customer_id') );
        }
        else
        {
            $customer = Customer::where('email', $request->email)->first();
            if (!$customer)
            {
                $customer = new Customer();
                $customer->name     = $request->name;
                $customer->email    = $request->email;
                $customer->mobile   = $request->mobile;
                $customer->password = bcrypt($request->mobile);
                $customer->save();
            }
            Session::put('customer_id', $customer->id);
            Session::put('customer_name', $customer->name);
        }


        if ($request->payment_method == 'cash')
        {
            $order = new Order();
            $order->customer_id     = $customer->id;
            $order->order_total     = $request->order_total;
            $order->tax_total       = $request->tax_total;
            $order->shipping_total  = $request->shipping_total;
            $order->order_date      = date('Y-m-d');
            $order->order_timestamp = strtotime(date('Y-m-d'));
            $order->delivery_address = $request->delivery_address;
            $order->payment_method   = $request->payment_method;
            $order->save();

            foreach (Cart::content() as $item)
            {
                $orderDetail = new OrderDetail();
                $orderDetail->order_id = $order->id;
                $orderDetail->product_id    = $item->id;
                $orderDetail->product_name  = $item->name;
                $orderDetail->product_price = $item->price;
                $orderDetail->product_qty   = $item->qty;
                $orderDetail->save();

                Cart::remove($item->rowId);
            }

            return redirect('/checkout/complete-order')->with('message', "Your order placed successfully. Please wait, we will contact with you soon.");
        }
        elseif ($request->payment_method == 'online')
        {
            $sslCommerzPaymentController = new SslCommerzPaymentController();
            $sslCommerzPaymentController->index($request, $customer);
        }



    }

    public function completeOrder()
    {
        return view('website.checkout.complete-order');
    }
}
