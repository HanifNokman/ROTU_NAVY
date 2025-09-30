<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function userManagement()
    {
        return view('admin.user_management');
    }

    public function dataManagement()
    {
        return view('admin.data_management');
    }

    public function accessManagement()
    {
        return view('admin.access_management');
    }
}
