<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Bus;
use Http\Discovery\Exception\NotFoundException;
use http\Env\Response;
use Illuminate\Http\Request;use Illuminate\Database\Eloquent\ModelNotFoundException;
use mysql_xdevapi\Exception;

class BusController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware('auth:api');
//        $this->middleware('role:admin,manager')->except(['index', 'show']);
//    }

    public function index()
    {
        $buses = Bus::all();
        return response()->json($buses);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'plate_number' => 'required|string|unique:buses',
            'total_seats' => 'required|integer|min:1',
            'status' => 'required|in:active,maintenance,inactive',
        ]);

        $bus = Bus::create($request->all());

        return response()->json([
            'message' => 'Bus created successfully',
            'bus' => $bus,
        ], 201);
    }

    public function show(string $bus)
    {
        try {
            $bus = Bus::findOrFail($bus);
            return response()->json([
                'message' => "Berhasil Menampilkan Data Bus",
                'bus' => $bus
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => "Data Bus Tidak Ditemukan",
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function update(Request $request, Bus $bus)
    {
        $request->validate([
            'name' => 'string|max:255',
            'plate_number' => 'string|unique:buses,plate_number,' . $bus->id,
            'total_seats' => 'integer|min:1',
            'status' => 'in:active,maintenance,inactive',
        ]);

        $bus->update($request->all());

        return response()->json([
            'message' => 'Bus updated successfully',
            'bus' => $bus,
        ]);
    }

    public function destroy(Bus $bus)
    {
        $bus->delete();

        return response()->json([
            'message' => 'Bus deleted successfully',
        ]);
    }

}
