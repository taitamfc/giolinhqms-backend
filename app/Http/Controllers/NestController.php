<?php

namespace App\Http\Controllers;

use App\Models\Nest;
use App\Http\Requests\StoreNestRequest;
use App\Http\Requests\UpdateNestRequest;
use App\Services\Interfaces\NestServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class NestController extends Controller
{
    protected $nestService;
    public function __construct(NestServiceInterface $nestService)
    {
        $this->nestService = $nestService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Nest::class);

        $items = $this->nestService->all($request);
        return view('nests.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Nest::class);
        return view('nests.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNestRequest $request)
    {
        $data = $request->except(['_token', '_method']);
        $this->nestService->store($data);
        return redirect()->route('nests.index')->with('success', 'Thêm mới thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $nest = Nest::find($id);
        $this->authorize('update', $nest);
        $nest = $this->nestService->find($id);
        return view('nests.edit', compact('nest'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNestRequest $request, $id)
    {
        $data = $request->except(['_token', '_method']);
        $nest = $this->nestService->update($data, $id);
        return redirect()->route('nests.index')->with('success', 'Cập Nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $nest = Nest::find($id);
        $this->authorize('delete', $nest);
        try {
            if ($this->nestService->isUserNest($id)) {
                return redirect()->back()->with('error', 'Trong tổ đang có giáo viên, không thể xóa!');
            }
            $this->nestService->destroy($id);
            return redirect()->route('nests.index')->with('success', 'Xóa thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Xóa thất bại!');
        }
    }
    public function trash(Request $request){
        $this->authorize('trash', Nest::class);
        $nests = $this->nestService->trash($request);
        return view('nests.trash',compact('nests'));

    }

    public function restore($id){
        $nest = Nest::find($id);
        $this->authorize('restore', $nest);
        try {
            $room = $this->nestService->restore($id);
            return redirect()->route('nests.trash')->with('success', 'Khôi phục thành công!');
        } catch (err) {
            return redirect()->route('nests.trash')->with('error', 'Khôi phục không thành công!');
        }
    }

    public function force_destroy($id){
        $nest = Nest::find($id);
        $this->authorize('forceDelete', $nest);
        try {
            $room = $this->nestService->forceDelete($id);
            return redirect()->route('nests.trash')->with('success', 'Xóa thành công!');
        } catch (err) {
            return redirect()->route('nests.trash')->with('error', 'Xóa không thành công!');
        }
    }
}
