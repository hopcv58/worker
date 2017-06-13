<?php

namespace App\Http\Controllers;

use App\Responsitory\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Webpatser\Uuid\Uuid;

class WorkerController extends Controller
{
    private $business;

    /**
     * WorkerController constructor.
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
        $worker = $this->business->getWorkerByUserId(Auth::user()->id);
        if (!isset($worker)) {
            return view('worker.index', compact('worker'));
        }
        $transactions = $this->business->getTransactionByWorkerId($worker->id);
        return view('worker.index', compact('worker', 'transactions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('worker.new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $duplicate = $this->business->getWorkerByUserId(Auth::user()->id);
        if(isset($duplicate)){
            redirect()->route('workers.show', $duplicate->id);
        } else {
            $request->id = Uuid::generate();
            $this->business->saveNewWorker($request);
            return redirect()->route('workers.show', $request->id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $worker = $this->business->getWorkerById($id);
//        return view("worker.show", compact("worker"));
        return response()->json($worker);
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
