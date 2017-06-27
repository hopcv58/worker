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
        $this->middleware('auth');
        $this->business = new Business();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        if (!isset(Auth::user()->id)) {
            return redirect()->route('login');
        }
        $duplicate = $this->business->getWorkerByUserId(Auth::user()->id);
        if (isset($duplicate)) {
            redirect()->route('workers.show', Auth::user()->id);
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
        if (!isset($worker)) {
            return view('worker.show', compact('worker'));
        }
        $transactions = $this->business->getTransactionByWorkerId($worker->id);
        return view('worker.show', compact('worker', 'transactions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
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

    public function showAddServiceForm()
    {

    }

    public function addNewService()
    {

    }
}
