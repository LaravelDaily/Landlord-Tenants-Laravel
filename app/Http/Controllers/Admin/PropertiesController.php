<?php

namespace App\Http\Controllers\Admin;

use App\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePropertiesRequest;
use App\Http\Requests\Admin\UpdatePropertiesRequest;
use App\Http\Controllers\Traits\FileUploadTrait;

class PropertiesController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of Property.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('property_access')) {
            return abort(401);
        }

        if (request('show_deleted') == 1) {
            if (! Gate::allows('property_delete')) {
                return abort(401);
            }
            $properties = Property::onlyTrashed()->get();
        } else {
            $properties = Property::all();
        }

        return view('admin.properties.index', compact('properties'));
    }

    /**
     * Show the form for creating new Property.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('property_create')) {
            return abort(401);
        }

        return view('admin.properties.create');
    }

    /**
     * Store a newly created Property in storage.
     *
     * @param  \App\Http\Requests\StorePropertiesRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePropertiesRequest $request)
    {
        if (! Gate::allows('property_create')) {
            return abort(401);
        }

        $request  = $this->saveFiles($request);
        $property = Property::create($request->all() + ['user_id' => auth()->user()->id]);

        return redirect()->route('admin.properties.index');
    }


    /**
     * Show the form for editing Property.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('property_edit')) {
            return abort(401);
        }

        $property = Property::findOrFail($id);

        return view('admin.properties.edit', compact('property'));
    }

    /**
     * Update Property in storage.
     *
     * @param  \App\Http\Requests\UpdatePropertiesRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePropertiesRequest $request, $id)
    {
        if (! Gate::allows('property_edit')) {
            return abort(401);
        }

        $request  = $this->saveFiles($request);
        $property = Property::findOrFail($id);
        $property->update($request->all());

        return redirect()->route('admin.properties.index');
    }


    /**
     * Display Property.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('property_view')) {
            return abort(401);
        }

        $documents = \App\Document::where('property_id', $id)->get();
        $notes     = \App\Note::where('property_id', $id)->get();
        $property  = Property::findOrFail($id);

        return view('admin.properties.show', compact('property', 'documents', 'notes'));
    }


    /**
     * Remove Property from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('property_delete')) {
            return abort(401);
        }

        $property = Property::findOrFail($id);
        $property->delete();

        return redirect()->route('admin.properties.index');
    }

    /**
     * Delete all selected Property at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('property_delete')) {
            return abort(401);
        }

        if ($request->input('ids')) {
            $entries = Property::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Property from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('property_delete')) {
            return abort(401);
        }

        $property = Property::onlyTrashed()->findOrFail($id);
        $property->restore();

        return redirect()->route('admin.properties.index');
    }

    /**
     * Permanently delete Property from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('property_delete')) {
            return abort(401);
        }

        $property = Property::onlyTrashed()->findOrFail($id);
        $property->forceDelete();

        return redirect()->route('admin.properties.index');
    }
}
