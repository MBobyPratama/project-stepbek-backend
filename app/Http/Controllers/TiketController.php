<?php

namespace App\Http\Controllers;

use App\Models\Tiket;
use App\Http\Requests\StoreTiketRequest;
use App\Http\Requests\UpdateTiketRequest;

class TiketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tikets = Tiket::all();
        return response()->json(['data' => $tikets]);
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
    public function store(StoreTiketRequest $request)
    {
        try {
            $tiket = Tiket::create($request->all());
            return response()->json([
                'message' => 'Tiket created successfully',
                'data' => $tiket
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create tiket',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Tiket $tiket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tiket $tiket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTiketRequest $request, Tiket $tiket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tiket $tiket)
    {
        //
    }
}
