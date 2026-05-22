<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Session;
use Illuminate\Http\Request;

class CustomerAuthController extends Controller
{
    public function login()
    {
        return view('website.auth.login');
    }

    public function loginCheck(Request $request)
    {
        $customer = Customer::where('email', $request->email)->first();
        if ($customer)
        {
            if (password_verify($request->password, $customer->password))
            {
                Session::put('customer_id', $customer->id);
                Session::put('customer_name', $customer->name);

                return redirect('/customer-dashboard');
            }
            else
            {
                return back()->with('message', 'Sorry ... Invalid password');
            }
        }
        else
        {
            return back()->with('message', 'Sorry ... Invalid email address');
        }
    }

    public function register()
    {
        return view('website.auth.register');
    }

    public function newCustomer(Request $request)
    {
        $customer = new Customer();
        $customer->name     = $request->name;
        $customer->email    = $request->email;
        $customer->mobile   = $request->mobile;
        $customer->password = bcrypt($request->password);
        $customer->save();

        Session::put('customer_id', $customer->id);
        Session::put('customer_name', $customer->name);

        return redirect('/customer-dashboard');
    }
}
