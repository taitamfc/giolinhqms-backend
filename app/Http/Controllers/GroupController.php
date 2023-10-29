<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\Interfaces\GroupServiceInterface;
use App\Services\Interfaces\RoleServiceInterface;
use Illuminate\Support\Facades\Log;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $groupService;
    protected $roleService;

    public function __construct(GroupServiceInterface $groupService, RoleServiceInterface $roleService)
    {
        $this->groupService = $groupService;
        $this->roleService = $roleService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Group::class);
        $users = User::get();
        $items = $this->groupService->all($request);
        $params =
            [
                'items' => $items,
                'users' => $users,
                'request' => $request,
            ];

        return view('groups.index', $params);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Group::class);
        return view('groups.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGroupRequest $request)
    {
        $data = $request->except(['_token', '_method']);
        $this->groupService->store($data);
        return redirect()->route('groups.index')->with('success', 'Thêm mới thành công!');
    }

    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $group = Group::find($id);
        $this->authorize('update', $group);
        $item = $this->groupService->find($id);
        return view('groups.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGroupRequest $request, $id)
    {
        $data = $request->except(['_token', '_method']);
        $this->groupService->update($id, $data);
        return redirect()->route('groups.index')->with('success', 'Cập Nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $group = Group::find($id);
        $this->authorize('delete', $group);
        try {
            if ($this->groupService->isUserGroup($id)) {
                return redirect()->back()->with('error', 'Đang có giáo viên trong nhóm quyền, không thể xóa!');
            }
            $this->groupService->destroy($id);
            return redirect()->route('groups.index')->with('success', 'Xóa thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Xóa thất bại!');
        }
    }
    public function show($id)
    {
        $item = $this->groupService->find($id);
        $roles = $this->roleService->all();
        $active_roles = $item->roles->pluck('id')->toArray();
        // dd($active_roles);
        $all_roles = [];
        foreach ($roles as $role) {
            $all_roles[$role['group_name']][] = $role;
        }
        $params['all_roles'] = $all_roles;
        $params['group'] = $item;
        $params['active_roles'] = $active_roles;
        return view('groups.show', $params);
    }
    public function saveRoles(Request $request, $id)
    {
        $group = $this->groupService->find($id);
        $group->roles()->detach();
        $group->roles()->attach($request->roles);
        return redirect()->route('groups.index')->with('success', 'Cấp quyền thành công !');
    }
}
