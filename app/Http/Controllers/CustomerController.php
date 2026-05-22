<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Session;

class CustomerController extends Controller
{
    public function index()
    {
        return view('customer.index');
    }

    public function profile()
    {
        return view('customer.profile', ['customer' => Customer::find( Session::get('customer_id') )]);
    }

    public function order()
    {
        return view('customer.order', ['orders' => Order::where('customer_id', Session::get('customer_id'))->latest()->get()]);
    }

    public function changePassword()
    {
        return view('customer.change-password');
    }

    public function logout()
    {
        Session::forget('customer_id');
        Session::forget('customer_name');

        return redirect('/');
    }
}
