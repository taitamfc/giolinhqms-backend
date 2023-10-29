<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;

class RoomController extends Controller
{
   
    public function index(Request $request)
    {
        $rooms = Room::all();
        return response()->json($rooms, 200);
    }
}
