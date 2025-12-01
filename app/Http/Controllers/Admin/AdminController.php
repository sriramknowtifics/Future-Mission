<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','role:admin']);
    }

    public function index()
    {
        // Dashboard: aggregate counts, recent orders, revenue summary (implement queries)
        // TODO: build queries and analytics
        return view('admin.dashboard');
    }
}
