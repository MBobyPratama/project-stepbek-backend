<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::all();
        return response()->json($events);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request)
    {
        $request->validated([
            'nama_event' => 'required|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:3048',
            'kategori' => 'required|string|in:seminar,workshop,kursus',
            'tema' => 'required|string|in:keterampilan & kejuruan,teknologi & digital,bisnis & kewirausahaan,pengembangan diri & soft skills',
            'deskripsi' => 'required|string',
            'nama_penyelenggara' => 'required|string',
            'tlg_listing' => 'required|date',
            'harga_tiket' => 'required|integer',
            'kuota' => 'required|integer',
            'kota' => 'required|string',
            'tempat' => 'required|string',
            'status_event' => 'required|string|in:upcoming,ongoing,complete,canceled',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date',
            'kontak_penyelenggara' => 'required|string',
            'tipe_tiket' => 'required|string|in:gratis,berbayar'
        ]);

        try {
            $event = Event::create($request->all());
            return response()->json([
                'message' => 'Event created successfully',
                'data' => $event
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create event',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        //
    }
}
