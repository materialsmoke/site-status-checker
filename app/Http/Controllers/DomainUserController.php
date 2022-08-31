<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDomainUserRequest;
use App\Http\Requests\UpdateDomainUserRequest;
use App\Models\DomainUser;

class DomainUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDomainUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDomainUserRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DomainUser  $domainUser
     * @return \Illuminate\Http\Response
     */
    public function show(DomainUser $domainUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DomainUser  $domainUser
     * @return \Illuminate\Http\Response
     */
    public function edit(DomainUser $domainUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDomainUserRequest  $request
     * @param  \App\Models\DomainUser  $domainUser
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDomainUserRequest $request, DomainUser $domainUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DomainUser  $domainUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(DomainUser $domainUser)
    {
        //
    }
}
