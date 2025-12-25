<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentsController extends Controller
{
    // store new document
    public function store(Request $request)
    {
        // authorization berlaku di sini
        abort_if(!Auth::user()->can('create-documents') , 403, "You're not an admin");
        // validate
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required'
        ]);
        // create that document!
        $document = Document::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'user_id' => Auth::id()
        ]);

        // return response json
        return response()->json([
            'success' => true,
            'message' => 'Document has created!',
            'data' => $document
        ],201);

    }
}
