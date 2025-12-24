<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use App\Http\Resources\DocumentResource;
use Illuminate\Support\Facades\Gate;

class DocumentsController extends Controller
{
    /**
     * Display a listing of documents.
     * All authenticated users can view documents.
     */
    public function index()
    {
        // Check permission
        abort_if(
            !auth()->user()->can('view-documents'),
            403,
            'You do not have permission to view documents.'
        );

        $documents = Document::get();

        return response()->json([
            'data' => DocumentResource::collection($documents),
            'message' => 'Documents retrieved successfully'
        ]);
    }

    /**
     * Store a newly created document.
     * Only managers and admins can create documents.
     */
    public function store(Request $request)
    {
        // Check permission
        abort_if(
            !auth()->user()->can('create-documents'),
            403,
            'You do not have permission to create documents. Please contact your manager.'
        );

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $document = Document::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'user_id' => auth()->id(),
        ]);

        return response()->json([
            'data' => new DocumentResource($document),
            'message' => 'Document created successfully'
        ], 201);
    }

    /**
     * Display the specified document.
     */
    public function show($id)
    {
        // Check permission
        abort_if(
            !auth()->user()->can('view-documents'),
            403,
            'You do not have permission to view this document.'
        );

        $document = Document::with('user')->findOrFail($id);

        return response()->json([
            'data' => new DocumentResource($document),
            'message' => 'Document retrieved successfully'
        ]);
    }

    /**
     * Update the specified document.
     * Only managers and admins can edit documents.
     */
    public function update(Request $request, $id)
    {
        // Check permission
        abort_if(
            !auth()->user()->can('edit-documents'),
            403,
            'You do not have permission to edit documents. Please contact your manager.'
        );

        $document = Document::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
        ]);

        $document->update($validated);

        return response()->json([
            'data' => new DocumentResource($document),
            'message' => 'Document updated successfully'
        ]);
    }

    /**
     * Remove the specified document.
     * Only admins can delete documents.
     */
    public function destroy($id)
    {
        // Check permission
        abort_if(
            !auth()->user()->can('delete-documents'),
            403,
            'You do not have permission to delete documents. Only administrators can perform this action.'
        );

        $document = Document::findOrFail($id);
        $document->delete();

        return response()->json([
            'message' => 'Document deleted successfully'
        ]);
    }

    /**
     * Get current user's permissions (helpful for frontend).
     */
    public function permissions()
    {
        $user = auth()->user();

        return response()->json([
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'roles' => $user->getRoleNames(),
                'permissions' => $user->getAllPermissions()->pluck('name'),
                'can' => [
                    'view_documents' => $user->can('view-documents'),
                    'create_documents' => $user->can('create-documents'),
                    'edit_documents' => $user->can('edit-documents'),
                    'delete_documents' => $user->can('delete-documents'),
                ]
            ]
        ]);
    }
}
