<?php

namespace App\Http\Controllers;

use App\Models\Commodity;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function dashboard(Request $request)
    {
        // $params = 1;
        $params = $request->query();
        // dd($params);
        $commodities = Commodity::myCommodity($params)->paginate(5);
        return view('dashboard', compact('commodities'));
    }
}
