<?php

namespace App\Http\Controllers;

use App\Models\WooRequest;
use Illuminate\Http\Request;

class WoocommerceController extends Controller
{

    public function membership_updated(Request $request)
    {
        sleep(5);
        $payload = $request->input();

        $obj = new WooRequest();
        $obj->type = 'woocommerce_membership_updated';
        $obj->payload = json_encode($payload);
        $obj->save();
    }
}
