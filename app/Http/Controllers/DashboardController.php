<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __constract() {
        $this->authorizeResource(Admin::class,'admin');
    }
    public function index() {
        return view('dashboard.index');
    }
}
