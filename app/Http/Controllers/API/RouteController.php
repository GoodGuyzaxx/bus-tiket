<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Route;
use Illuminate\Http\Request;

class RouteController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware('auth:api');
//        $this->middleware('role:admin,manager')->except(['index', 'show']);
//    }

    public function index()
    {
        $routes = Route::with('bus')->get();
        return response()->json($routes);
    }

    public function store(Request $request)
    {
        $request->validate([
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'departure_time' => 'required|date_format:H:i',
            'arrival_time' => 'required|date_format:H:i',
            'bus_id' => 'required|exists:buses,id',
            'status' => 'required|in:active,inactive',
        ]);

        $route = Route::create($request->all());

        return response()->json([
            'message' => 'Route created successfully',
            'route' => $route,
        ], 201);
    }

    public function show(Route $route)
    {
        return response()->json($route->load('bus'));
    }

    public function update(Request $request, Route $route)
    {
        $request->validate([
            'origin' => 'string|max:255',
            'destination' => 'string|max:255',
            'price' => 'numeric|min:0',
            'departure_time' => 'date_format:H:i',
            'arrival_time' => 'date_format:H:i',
            'bus_id' => 'exists:buses,id',
            'status' => 'in:active,inactive',
        ]);

        $route->update($request->all());

        return response()->json([
            'message' => 'Route updated successfully',
            'route' => $route,
        ]);
    }

    public function destroy(Route $route)
    {
        $route->delete();

        return response()->json([
            'message' => 'Route deleted successfully',
        ]);
    }
}
