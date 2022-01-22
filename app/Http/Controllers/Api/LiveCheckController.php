<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LiveCheckController extends Controller
{
    public function __construct() {
        $this->middleware('authDevice:api');
    }

    public function check(Request $request)
    {
        $controlDevice = $request['controlDevice'];
        $data = Carbon::now();
        $controlDevice->last_contact = $data;
        $controlDevice->save();
    }
}
