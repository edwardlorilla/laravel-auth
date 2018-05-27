<?php

namespace App\Http\Controllers;

use App\File;
use Illuminate\Http\Request;

class FileController extends Controller
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
        $document = auth()->user()->documents()->where('id', (int)$request->id)->first();
        if ( $files = $request->file('file')) {
            foreach ($request->file('file') as $key => $file) {
                $name = time().$key.$file->getClientOriginalName();
                $filename = $file->move('files',$name);
                $document->files()->save(new \App\File([
                    'name' => $name,
                    'file' => $file->getClientOriginalName(),
                    'type' => $file->getClientOriginalExtension()
                ]));
            }
        }
        return response()->json( $document->where('id', $document->id)->with('files:id,file,type')->first(), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\File  $file
     * @return \Illuminate\Http\Response
     */
    public function show(File $file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\File  $file
     * @return \Illuminate\Http\Response
     */
        public function update(Request $request, File $file)
    {
        //
    }

        /**
         * Remove the specified resource from storage.
         *
         * @param  \App\File  $file
         * @return \Illuminate\Http\Response
         */
        public function destroy(File $file)
    {

        if (!(empty($file->name))) {
            if (file_exists(public_path() . '/files/' . $file->name)){
                unlink(public_path() . '/files/' . $file->name);
            }
            File::where('id', $file->id)->delete();
        }
        return response()->json(null, 200);
    }
}
