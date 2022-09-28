<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Domain;
use App\Http\Requests\StoreDomainRequest;
use App\Http\Requests\UpdateDomainRequest;
use App\Models\CheckSitemapDomain;
use App\Models\CurlDetail;
use Illuminate\Support\Facades\Auth;

class CheckSitemapDomainController extends Controller
{
    public function index()
    {
        
    }

    public function store()
    {
        
    }

    public function show($domainId)
    {
        $checkSitemapDomain = CheckSitemapDomain::where('domain_id', $domainId)->orderBy('created_at', 'desc')->limit(200)->get(['id', 'created_at', 'status', 'is_healthy']);

        if($checkSitemapDomain){
        
            return response()->json([
                'data' => $checkSitemapDomain,
                'status' => 'success',
            ], 200);
        }

        return response()->json([
            'data' => [],
        ], 404);
    }

    public function update()
    {
        
    }
    
    public function delete()
    {
        
    }
}