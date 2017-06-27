<?php

namespace App\Http\Controllers;

use App\Responsitory\Business;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $business;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->business = new Business();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->business->getAllGrandCategories();
        return view('home', compact("categories"));
    }

    public function showProfile()
    {

    }
}
