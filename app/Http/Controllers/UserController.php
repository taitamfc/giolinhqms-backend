<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\ImportUserRequest;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Nest;
use App\Models\User;
use App\Models\Borrow;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;

use App\Services\Interfaces\BorrowServiceInterface;
use App\Services\Interfaces\DeviceServiceInterface;
use Illuminate\Support\Facades\DB;
use App\Services\Interfaces\UserServiceInterface;
use App\Services\Interfaces\GroupServiceInterface;
use App\Services\Interfaces\NestServiceInterface;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    protected $userService;
    protected $groupService;
    protected $borrowService;
    protected $deviceService;
    protected $nestService;

    public function __construct(UserServiceInterface $userService, NestServiceInterface $nestService, GroupServiceInterface $groupService, BorrowServiceInterface $borrowService, DeviceServiceInterface $deviceService,)
    {
        $this->groupService = $groupService;
        $this->userService = $userService;
        $this->borrowService = $borrowService;
        $this->deviceService = $deviceService;
        $this->nestService = $nestService;
    }
    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);
        $items = $this->userService->all($request);
        $groups = Group::get();
        $nests = Nest::get();
        $param =
            [
                'items' => $items,
                'request' => $request,
                'groups' => $groups,
                'nests' => $nests,
            ];
        return view('users.index', $param);
    }
    public function create()
    {
        $this->authorize('create', User::class);

        $groups = Group::get();
        $nests = Nest::get();
        $params =
            [
                'groups' => $groups,
                'nests' => $nests,
            ];
        return view('users.create', $params);
    }
    public function store(StoreUserRequest $request)
    {
        $data = $request->except(['_token', '_method']);
        $this->userService->store($data);
        return redirect()->route('users.index')->with('success', 'Thêm mới thành công!');
    }
    public function edit($id)
    {
        $user = User::find($id);
        $this->authorize('update', $user);

        $groups = Group::get();
        $nests = Nest::get();
        $item = $this->userService->find($id);
        $params =
            [
                'groups' => $groups,
                'nests' => $nests,
                'item' => $item,
            ];
        return view('users.edit', $params);
    }
    public function update(UpdateUserRequest $request, $id)
    {
        $data = $request->except(['_token', '_method']);
        $this->userService->update($id, $data);
        return redirect()->route('users.index')->with('success', 'Cập Nhật thành công!');
    }
    public function destroy($id)
    {
        $user = User::find($id);
        $this->authorize('delete', $user);
        try {
            if ($this->userService->isUserBorrow($id)) {
                return redirect()->back()->with('error', 'Người dùng đang mượn thiết bị, không thể xóa!');
            }

            $this->userService->destroy($id);
            return redirect()->route('users.index')->with('success', 'Xóa người dùng thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Xóa thất bại!');
        }
    }

    public function show($id)
    {
        $user = User::find($id);
        $this->authorize('view', $user);
        $item = $this->userService->find($id);
        return view('users.show', compact('item'));
    }
    public function trash(Request $request)
    {
        $this->authorize('trash', User::class);
        $users = $this->userService->trash($request);
        return view('users.trash', compact('users', 'request'));
    }
    public function restore($id)
    {
        $user = User::find($id);
        $this->authorize('restore', $user);
        try {
            $user = $this->userService->restore($id);
            return redirect()->route('users.trash')->with('success', 'Khôi phục thành công!');
        } catch (err) {
            return redirect()->route('users.trash')->with('error', 'Khôi phục thất bại!');
        }
    }
    public function force_destroy($id)
    {
        $user = User::find($id);
        $this->authorize('forceDelete', $user);
        try {
            $user = $this->userService->forceDelete($id);
            return redirect()->route('users.trash')->with('success', 'Xóa thành công!');
        } catch (err) {
            return redirect()->route('users.trash')->with('success', 'Xóa thất bại!');
        }
    }
    public function history(Request $request, $id)
    {
        $user = $this->userService->find($id);
        $changeStatus = [
            0 => 'Chưa trả',
            1 => 'Đã trả',
        ];
        $changeApproved = [
            0 => 'Chưa xét duyệt',
            1 => 'Đã xét duyệt',
            2 => 'Từ chối',
        ];
        $queryBuilder = $this->userService->history($id);
        $history = $queryBuilder->paginate(20);
        // dd($history);
        return view('users.history', compact('user', 'history', 'changeStatus', 'changeApproved'));
    }
    function getImport(){
        return view('users.import');
    }
    public function import(ImportUserRequest $request) 
    {
        try {
            Excel::import(new UsersImport, request()->file('importData'));
            return redirect()->route('users.index')->with('success', 'Thêm thành công');
        } catch (Exception $e) {
            return redirect()->route('users.index')->with('error', 'Thêm thất bại');
        }
    }
}