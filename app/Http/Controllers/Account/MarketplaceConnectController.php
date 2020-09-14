<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;

class MarketplaceConnectController extends Controller
{
    public function index()
    {
        return view('account.marketplace.index');
    }
}
