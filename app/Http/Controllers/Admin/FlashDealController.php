<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FlashDealController extends Controller
{
    public function index()
    {
        return view('admin.flash_deals.index');
    }
}
