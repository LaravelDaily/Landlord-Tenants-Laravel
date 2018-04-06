<?php

namespace App\Http\Controllers\Admin;

use App\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreNotesRequest;
use App\Http\Requests\Admin\UpdateNotesRequest;

class NotesController extends Controller
{
    /**
     * Display a listing of Note.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('note_access')) {
            return abort(401);
        }

        if (request('show_deleted') == 1) {
            if (! Gate::allows('note_delete')) {
                return abort(401);
            }
            $notes = Note::onlyTrashed()->get();
        } else {
            $notes = Note::all();
        }

        return view('admin.notes.index', compact('notes'));
    }

    /**
     * Show the form for creating new Note.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('note_create')) {
            return abort(401);
        }

        $properties = \App\Property::get()->pluck('name', 'id');

        return view('admin.notes.create', compact('properties'));
    }

    /**
     * Store a newly created Note in storage.
     *
     * @param  \App\Http\Requests\StoreNotesRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNotesRequest $request)
    {
        if (! Gate::allows('note_create')) {
            return abort(401);
        }

        $note = Note::create($request->all());

        return redirect()->route('admin.notes.index');
    }


    /**
     * Show the form for editing Note.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('note_edit')) {
            return abort(401);
        }

        $properties = \App\Property::get()->pluck('name', 'id');
        $note       = Note::findOrFail($id);

        return view('admin.notes.edit', compact('note', 'properties'));
    }

    /**
     * Update Note in storage.
     *
     * @param  \App\Http\Requests\UpdateNotesRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNotesRequest $request, $id)
    {
        if (! Gate::allows('note_edit')) {
            return abort(401);
        }

        $note = Note::findOrFail($id);
        $note->update($request->all());

        return redirect()->route('admin.notes.index');
    }


    /**
     * Display Note.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('note_view')) {
            return abort(401);
        }

        $note = Note::findOrFail($id);

        return view('admin.notes.show', compact('note'));
    }


    /**
     * Remove Note from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('note_delete')) {
            return abort(401);
        }

        $note = Note::findOrFail($id);
        $note->delete();

        return redirect()->route('admin.notes.index');
    }

    /**
     * Delete all selected Note at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('note_delete')) {
            return abort(401);
        }

        if ($request->input('ids')) {
            $entries = Note::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Note from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('note_delete')) {
            return abort(401);
        }

        $note = Note::onlyTrashed()->findOrFail($id);
        $note->restore();

        return redirect()->route('admin.notes.index');
    }

    /**
     * Permanently delete Note from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('note_delete')) {
            return abort(401);
        }

        $note = Note::onlyTrashed()->findOrFail($id);
        $note->forceDelete();

        return redirect()->route('admin.notes.index');
    }
}
