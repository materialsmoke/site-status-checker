<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCurlDetailRequest;
use App\Http\Requests\UpdateCurlDetailRequest;
use App\Models\CurlDetail;
use Illuminate\Support\Facades\Log;

class CurlDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($domainId)
    {
        $minutes = request()->input('minutes');
        Log::info('sdjfasjdfjaldskfkjsadfjkdsfkjl ' . $minutes);
        // print_r($minutes);
        
        // if(! isset($minutes)){
        //     $minutes = 1440;
        // }

        $curlDetails = CurlDetail::where('domain_id', $domainId)->where('created_at', '>', now()->subMinutes($minutes))->get();

        return $curlDetails;
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
     * @param  \App\Http\Requests\StoreCurlDetailRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCurlDetailRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CurlDetail  $curlDetail
     * @return \Illuminate\Http\Response
     */
    public function show(CurlDetail $curlDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CurlDetail  $curlDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(CurlDetail $curlDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCurlDetailRequest  $request
     * @param  \App\Models\CurlDetail  $curlDetail
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCurlDetailRequest $request, CurlDetail $curlDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CurlDetail  $curlDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(CurlDetail $curlDetail)
    {
        //
    }
}
