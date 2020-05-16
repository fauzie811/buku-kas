<?php

namespace App\Http\Controllers;

use App\Cashbook;
use Illuminate\Http\Request;

class CashbookController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cashbooks = Cashbook::all();

        return view('cashbooks.index', compact(['cashbooks']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cashbooks.create');
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
            'name' => ['required', 'string'],
        ]);

        Cashbook::create($request->only(['name']));

        return redirect()->route('cashbooks.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cashbook  $cashbook
     * @return \Illuminate\Http\Response
     */
    public function show(Cashbook $cashbook)
    {
        return view('cashbooks.show', compact(['cashbook']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cashbook  $cashbook
     * @return \Illuminate\Http\Response
     */
    public function edit(Cashbook $cashbook)
    {
        return view('cashbooks.edit', compact(['cashbook']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cashbook  $cashbook
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cashbook $cashbook)
    {
        $this->validate($request, [
            'name' => ['nullable', 'string'],
        ]);

        $cashbook->update($request->only(['name']));

        return redirect()->route('cashbooks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cashbook  $cashbook
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cashbook $cashbook)
    {
        $cashbook->delete();

        return redirect()->route('cashbooks.index');
    }
}
