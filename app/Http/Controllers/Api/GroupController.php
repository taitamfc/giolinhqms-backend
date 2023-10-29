<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\GroupServiceInterface;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    protected $groupService;
    public function __construct(GroupServiceInterface $groupService)
    {
        $this->groupService = $groupService;
    }
    public function index(Request $request)
    {
        $groups = $this->groupService->all($request);

        // Chỉ lấy id và tên từ dữ liệu groups
        $groupIds = $groups->map(function ($group) {
            return [
                'id' => $group->id,
                'name' => $group->name,
            ];
        });

        return response()->json($groupIds, 200);
    }
}
