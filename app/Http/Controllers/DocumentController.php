<?php

namespace App\Http\Controllers;

use App\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function __construct()
    {
        $this->middleware('user_type', ['except' => 'index']);
    }
    /**
     * App\Post::find(1)->documents;
     *insert - auth()->user()->documents()->save(new Announcement($validateData));
     *update - auth()->user()->documents()->where('id', id)->update($validateData));
     *delete - auth()->user()->documents()->where('id', id)->delete();
     */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Document::with('files:id,file,type', 'category:id,title')->latest()->get();
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
            'title' => 'required',
            'file.*' => 'required',
            'category_id' => 'required'
        ]);
        $document = auth()->user()->documents()->save(new Document(['title' => $request->title, 'category_id' => (int)$request->category_id]));
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
        return response()->json( $document->where('id', $document->id)->with('files:id,file,type', 'category:id,title')->first(), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Document $document)
    {

        $validateData = request()->validate([
            'title' => 'required',
            'category_id' => 'required',
        ]);
        $update = auth()->user()->documents()->where('id', $document->id);
        $update->update($validateData);

        return response()->json($update->with('files:id,file,type',  'category:id,title')->first(), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document)
    {
        auth()->user()->documents()->where('id', $document->id)->delete();
        return response()->json(null, 204);
    }
}
