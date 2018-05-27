<?php

namespace App\Http\Controllers;

use App\Contribution;
use Illuminate\Http\Request;

class ContributionController extends Controller
{
    public function __construct()
    {
        $this->middleware('user_type', ['except' => ['store', 'update', 'destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Contribution::with('user:id,email,first_name,last_name', 'transaction:id,title')->latest()->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validateData = request()->validate([
            'user_id' => 'required',
            'transaction_id.*' => 'required',
            'amount.*' => 'required|numeric',
        ]);
        $user = \App\User::whereId($request->user_id)->first();
        $contribution = [];
        for ($x = 0; $x <= count($request->transaction_id) - 1; ++$x) {
            $contribution[] =$user->contributions()->save(
                new Contribution([
                    'transaction_id' => (int)$request->transaction_id[$x],
                    'amount' => (int)$request->amount[$x]
                ]))->id;

        }


        return  response()->json(auth()->user()->contributions()->whereIn('id', $contribution)->with('user:id,email,first_name,last_name','transaction:id,title')->latest()->get(), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contribution  $contribution
     * @return \Illuminate\Http\Response
     */
    public function show(Contribution $contribution)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contribution  $contribution
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contribution $contribution)
    {
        $validateData = request()->validate([
            'transaction_id' => 'required',
            'amount' => 'required'
        ]);
        return auth()->user()->contributions()->save(new Contribution($validateData));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contribution  $contribution
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contribution $contribution)
    {
        auth()->user()->contributions()->where('id', $contribution->id)->delete();
        return response()->json(null, 204);
    }
}
