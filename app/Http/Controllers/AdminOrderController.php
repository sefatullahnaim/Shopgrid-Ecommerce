<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use PDF;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index()
    {
        return view('admin.order.index', ['orders' => Order::all()]);
    }

    public function detail($id)
    {
        return view('admin.order.detail', ['order' => Order::find($id)]);
    }

    public function edit($id)
    {
        return view('admin.order.edit', ['order' => Order::find($id)]);
    }

    public function updateOrder(Request $request, $id)
    {
        $order = Order::find($id);
        if ($request->order_status == 'Pending') {
            $order->order_status    = $request->order_status;
            $order->delivery_status = $request->order_status;
            $order->payment_status  = $request->order_status;
        } elseif ($request->order_status == 'Processing') {
            $order->order_status        = $request->order_status;
            $order->delivery_status     = $request->order_status;
            $order->payment_status      = $request->order_status;
            $order->delivery_address    = $request->delivery_address;
            $order->courier_id          = $request->courier_id;
        } elseif ($request->order_status == 'Complete') {
            $order->order_status        = $request->order_status;
            $order->delivery_status     = $request->order_status;
            $order->payment_status      = $request->order_status;
            $order->delivery_date       = $request->delivery_date;
            $order->delivery_timestamp  = strtotime($request->delivery_date);
            $order->payment_amount      = $order->order_total;
            $order->payment_date        = date('Y-m-d');
            $order->payment_timestamp   = strtotime(date('Y-m-d'));
        } elseif ($request->order_status == 'Cancel') {
            $order->order_status        = $request->order_status;
            $order->delivery_status     = $request->order_status;
            $order->payment_status      = $request->order_status;
        }
        $order->save();
        return redirect('/all-order')->with('message', 'Order status info update successfully.');
    }

    public function invoice($id)
    {
        return view('admin.order.invoice', ['order' => Order::find($id)]);
    }

    public function downloadInvoice($id)
    {
        //$output = PDF::loadHTML('<h1>Test</h1>');
        $data = ['name' => 'BITM', 'location' => 'Dhaka'];
        $output = PDF::loadView('admin.order.download-invoice', ['order' => Order::find($id)]);
        return $output->download('invoice-0' . $id . '.pdf');

        //return view('admin.order.download-invoice');
    }

    public function deleteOrder($id)
    {
        Order::find($id)->delete();
        $orderDetails = OrderDetail::where('order_id', $id)->get();
        foreach ($orderDetails as $orderDetail) {
            $orderDetail->delete();
        }
        return back()->with('message', 'Delete successfully.');
    }
}
