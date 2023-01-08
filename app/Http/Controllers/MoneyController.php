<?php

namespace App\Http\Controllers;

use App\Models\Money;
use Illuminate\Http\Request;

class MoneyController extends Controller
{
    public function index()
    {
        $money = Money::latest()->get();

        return view('pages.index', [
            'moneys' => $money
        ]);
    }
}
