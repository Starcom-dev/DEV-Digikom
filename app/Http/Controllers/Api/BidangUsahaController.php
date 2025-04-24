<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BidangUsahaResource;
use App\Models\BidangUsaha;
use Illuminate\Http\Request;

class BidangUsahaController extends Controller
{
    public function index()
    {
        $bidangUsaha = BidangUsaha::orderBy('nama', 'ASC')->get();
        return new BidangUsahaResource(true, 'List Data Bidang Usaha', $bidangUsaha);
    }
}
