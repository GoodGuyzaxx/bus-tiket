<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Models\Bus;
use Illuminate\Http\Request;

class BusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Bus::all();
        return view('pages.admin.bus.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.bus.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'plate_number' => 'required',
            'total_seats' => 'required|integer',
            'status' => 'required'
        ]);

        Bus::create([
            'name' => $request->name,
            'plate_number' => $request->plate_number,
            'total_seats' => $request->total_seats,
            'status' => $request->status
        ]);

        return redirect()->route('bus.index')->with('success', 'Bus created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Bus::find($id);
        return view('pages.admin.bus.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $bus = Bus::find($id);
        return view('pages.admin.bus.edit', compact('bus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'name' => 'required',
            'plate_number' => 'required',
            'total_seats' => 'required|integer',
            'status' => 'required'
        ]);

        Bus::find($id)->update([
            'name' => $request->name,
            'plate_number' => $request->plate_number,
            'total_seats' => $request->total_seats,
            'status' => $request->status
        ]);

        return redirect()->route('bus.index')->with('success', 'Bus updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Bus::find($id)->delete();
        return redirect()->route('bus.index')->with('success', 'Bus deleted successfully');
    }

}
