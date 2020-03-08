<?php

namespace App\Http\Controllers;

use App\CashType;
use Illuminate\Http\Request;

class CashTypeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'can:admin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cash_types = CashType::all();

        return view('cash-types.index', compact('cash_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'type' => ['required', 'in:in,out'],
            'description' => ['required', 'string'],
        ]);

        CashType::create($request->only(['type', 'description']));

        return redirect()->route('cash-types.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CashType  $cashType
     * @return \Illuminate\Http\Response
     */
    public function show(CashType $cashType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CashType  $cashType
     * @return \Illuminate\Http\Response
     */
    public function edit(CashType $cashType)
    {
        return view('cash-types.edit', compact('cashType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CashType  $cashType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CashType $cashType)
    {
        $this->validate($request, [
            'type' => ['required', 'in:in,out'],
            'description' => ['required', 'string'],
        ]);

        $cashType->update($request->only(['type', 'description']));

        return redirect()->route('cash-types.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CashType  $cashType
     * @return \Illuminate\Http\Response
     */
    public function destroy(CashType $cashType)
    {
        $cashType->delete();

        return \redirect()->route('cash-types.index');
    }
}
