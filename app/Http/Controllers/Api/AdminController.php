<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\AdminResource;
use App\Models\Admin;

class AdminController extends Controller
{
    public function index()
    {
        //get all posts
        $admins = Admin::latest()->get();
        //return collection of posts as a resource
        return new AdminResource(true, 'List Data Admin', $admins);
    }
}
