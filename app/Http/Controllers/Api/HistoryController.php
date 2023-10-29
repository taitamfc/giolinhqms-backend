<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\Interfaces\UserServiceInterface;

class HistoryController extends Controller
{

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }
    public function getHistories(Request $request){

        $id = $request->id;
        $user = $this->userService->find($id);
        $history = $this->userService->history($id);
        $history = $history->get();
        $dataHistory = [
            'user' => $user,
            'history' => $history
        ];
        return response()->json($dataHistory, 200); 
    }
}
