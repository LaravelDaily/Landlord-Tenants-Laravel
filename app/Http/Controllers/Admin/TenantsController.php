<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreTenantsRequest;
use App\Notifications\InvitationSend;
use App\Property;
use App\Http\Controllers\Controller;
use App\User;

class TenantsController extends Controller
{

    /**
     * Display a listing of Tenants.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tenants = User::whereIn('property_id', Property::where('user_id', auth()->user()->id)->pluck('id'))->get();

        return view('admin.tenants.index', compact('tenants'));
    }

    /**
     * Show the form for creating new Tenant.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $properties = Property::where('user_id', auth()->user()->id)->pluck('name', 'id');

        return view('admin.tenants.create', compact('properties'));
    }

    /**
     * Store a newly created Tenant in storage.
     *
     * @param  \App\Http\Requests\StoreTenantsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTenantsRequest $request)
    {
        $user = User::create([
            'name'             => $request->name,
            'email'            => $request->email,
            'password'         => str_random(8),
            'property_id'      => $request->property_id,
            'invitation_token' => substr(md5(rand(0, 9) . $request->email . time()), 0, 32),
        ]);

        $user->role()->attach(3);

        $user->notify(new InvitationSend());

        return redirect()->route('admin.tenants.index');
    }


    /**
     * Remove Property from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $property = Property::findOrFail($id);
        $property->delete();

        return redirect()->route('admin.properties.index');
    }

}
