<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreStatsRequest;
use App\Http\Requests\UpdateStatsRequest;
use App\Models\Stats;
use Illuminate\Support\Facades\Storage;

class StatsController extends Controller
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
        return inertia('Stats/Create', [
            'status' => session('status'),
            'model'  => $model,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStatsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Stats $stats)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stats $stats)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStatsRequest $request, Stats $stats)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stats $stats)
    {
        //
    }
}
