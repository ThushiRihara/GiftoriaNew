<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // Blade view
    public function index() {
        return view('admin.customers.manage');
    }

    // API to fetch customers
    public function getCustomers(Request $request) {
        $customers = Customer::all(); // or ->paginate(20) if many
        return response()->json($customers);
    }
}
