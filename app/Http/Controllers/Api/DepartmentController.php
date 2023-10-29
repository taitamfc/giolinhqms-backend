<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Interfaces\DepartmentServiceInterface;

class DepartmentController extends Controller
{
    protected $departmentService;
    public function __construct(DepartmentServiceInterface $departmentService)
    {
        $this->departmentService = $departmentService;
    }
    public function index(Request $request)
    {
        $departments = $this->departmentService->all($request);
        $departmentIds = $departments->map(function ($department) {
            return [
                'id' => $department->id,
                'name' => $department->name,
            ];
        });
        return response()->json($departments, 200);
    }
}
