<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Models\Bus;
use Illuminate\Http\Request;
use App\Models\Route;

class RuteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Route::with('bus')->get();
        return view('pages.admin.rute.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $buses = Bus::get();
        return view('pages.admin.rute.create', compact('buses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'origin' => 'required',
            'destination' => 'required',
            'price' => 'required|numeric',
            'departure_time' => 'required',
            'arrival_time' => 'required',
            'bus_id' => 'required',
            'status' => 'required'
        ]);

        Route::create([
            'origin' => $request->origin,
            'destination' => $request->destination,
            'price' => $request->price,
            'departure_time' => $request->departure_time,
            'arrival_time' => $request->arrival_time,
            'bus_id' => $request->bus_id,
            'status' => $request->status,
            'create_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('rute.index')->with('success', 'Rute Berhail Dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $rute = Route::find($id);
        $buses = Bus::get();
        return view('pages.admin.rute.edit', compact('rute', 'buses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'origin' => 'required',
            'destination' => 'required',
            'price' => 'required|numeric',
            'departure_time' => 'required',
            'arrival_time' => 'required',
            'bus_id' => 'required',
            'status' => 'required'
        ]);

        Route::find($id)->update([
            'origin' => $request->origin,
            'destination' => $request->destination,
            'price' => $request->price,
            'departure_time' => $request->departure_time,
            'arrival_time' => $request->arrival_time,
            'bus_id' => $request->bus_id,
            'status' => $request->status,
            'updated_at' => now()
        ]);

        return redirect()->route('rute.index')->with('success', 'Rute Berhasil Diupdate!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Route::find($id)->delete();
        return redirect()->route('rute.index')->with('success', 'Rute Berhail Dihapus!');
    }
}
