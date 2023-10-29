<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\NestServiceInterface;
use Illuminate\Http\Request;

class NestController extends Controller
{
    protected $nestService;
    public function __construct(NestServiceInterface $nestService)
    {
        $this->nestService = $nestService;
    }
    public function index(Request $request)
    {
        $nests = $this->nestService->all($request);
        $nestIds = $nests->map(function ($nest) {
            return [
                'id' => $nest->id,
                'name' => $nest->name,
            ];
        });
        return response()->json($nestIds, 200);
    }
}
