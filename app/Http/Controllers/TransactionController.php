<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Responsitory\Business;
use Illuminate\Support\Facades\Auth;
use Webpatser\Uuid\Uuid;

class TransactionController extends Controller
{
    private $business;

    /**
     * TransactionController constructor.
     */
    public function __construct()
    {
        $this->business = new Business();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!isset(Auth::user()->id)){
            return redirect()->route('login');
        }
        $customer = $this->business->getCustomerByUserId(Auth::user()->id);
        if (!isset($customer)) {
            return view('transaction.index', compact('customer'));
        }
        $transactions = $this->business->getTransactionByCustomerId($customer->id);
        return view('transaction.index', compact('customer', 'transactions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('transaction.new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->id = Uuid::generate();
        $this->business->saveNewTransaction($request);
        return redirect()->route('transactions.show', $request->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaction = $this->business->getTransactionById($id);
        //        return view("worker.show", compact("transaction"));
        return response()->json($transaction);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
