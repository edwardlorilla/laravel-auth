<?php

namespace App\Http\Controllers;

use App\Performance;
use Illuminate\Http\Request;

class PerformanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('user_type');
    }

    public function index()
    {
        return Performance::latest()->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validateData = request()->validate([

            'target' => 'required | numeric',
            'user_id' => 'required | numeric',
            'school_year_start' => 'required',
            'school_year_end' => 'required',
            'semester' => 'required | numeric',
            'ceta' => 'required | numeric',
            'etd' => 'required | numeric',
            'etp' => 'required | numeric',
            'ets' => 'required | numeric',
            'etse' => 'required | numeric'
        ]);

        $user = \App\User::findOrFail($request->user_id);
        return $user->performances()->updateOrCreate([
            'user_id' => $request->user_id,
            'school_year_start' => $request->school_year_start,
            'school_year_end' => $request->school_year_end,
            'semester' => $request->semester
        ],
            $validateData
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Performance $performance
     * @return \Illuminate\Http\Response
     */
    public function show(Performance $performance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Performance $performance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Performance $performance)
    {
        $validateData = request()->validate([
            'target' => 'required | numeric',
            'user_id' => 'required | numeric',
            'school_year_start' => 'required',
            'school_year_end' => 'required',
            'semester' => 'required | numeric',
            'ceta' => 'required | numeric',
            'etd' => 'required | numeric',
            'etp' => 'required | numeric',
            'ets' => 'required | numeric',
            'etse' => 'required | numeric'
        ]);
        $performance->update($validateData);
        return response()->json(Performance::where('id', $performance->id)->first());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Performance $performance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Performance $performance)
    {
        $performance->delete();
        return response()->json([], 204);
    }
}
