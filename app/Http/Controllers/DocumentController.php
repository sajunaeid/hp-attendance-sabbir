<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Http\Requests\StoreDocumentRequest;
use App\Http\Requests\UpdateDocumentRequest;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDocumentRequest $request)
    {

        $document = new Document;
        $document->employee_id = $request->employee_id;
        $document->docname = $request->docname;


        if ($request->file('docpath')) {
            $file = $request->file('docpath');
            $image_full_name = time().'docpath'.'.'.$file->getClientOriginalExtension();
            $upload_path = 'empdocuments/';
            $image_url = $upload_path.$image_full_name;
            $success = $file->move($upload_path, $image_full_name);
            $document->docpath = $image_url;
        }


        $document->save();

        return redirect()->route('employees.show', $request->employee_id)->with(['status' => 200, 'message' => 'Document Added.']);

    }


    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        // $filePath = public_path("name_of_your_file.txt");
        return response()->download($document->docpath);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDocumentRequest $request, Document $document)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        return 'Hello';
    }
}
