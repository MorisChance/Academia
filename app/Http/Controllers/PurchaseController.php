<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commodity;
use App\Models\Purchase;
use App\Models\User;

class PurchaseController extends Controller
{

    public function create(Commodity $commodity){
    
    return view('purchases.create', compact('commodity'));
}

}


