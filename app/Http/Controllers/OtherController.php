<?php

namespace App\Http\Controllers;

use App\Responsitory\Business;
use Illuminate\Http\Request;

class OtherController extends Controller
{
    private $business;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
        $this->business = new Business();
    }

    public function search(Request $request)
    {
        //search for worker
        /* if (!isset($request->address) && !isset($request->category)) {
            return view('search');
        } else {
            $district_id = $this->business->getDistrictIdFromAddress($request->address);
            $workers = $this->business->getWorkerByCategoryAndDistrict($request->category, $district_id);
            return view('search', compact('workers'));
        } */
        //search for child category
        $categories = $this->business->searchChildCategoriesByName($request->category, $request->address);
        return view('searchChild', compact('categories'));
    }

    public function showProfile()
    {
        //
    }
}
