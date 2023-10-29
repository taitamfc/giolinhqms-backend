<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrow;
use App\Models\User;
use App\Models\Room;
use App\Models\Device;
use App\Models\BorrowDevice;
use App\Models\Nest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


use App\Services\Interfaces\BorrowServiceInterface;
use App\Services\Interfaces\DeviceServiceInterface;

use App\Services\Interfaces\RoomServiceInterface;
use App\Services\Interfaces\UserServiceInterface;


use App\Http\Requests\StoreBorrowRequest;
use App\Http\Requests\UpdateBorrowRequest;



class BorrowController extends Controller
{
    protected $borrowService;
    protected $deviceService;
    protected $roomService;
    protected $userService;

    public function __construct(BorrowServiceInterface $borrowService, DeviceServiceInterface $deviceService, RoomServiceInterface $roomService, UserServiceInterface $userService)
    {
        $this->borrowService = $borrowService;
        $this->deviceService = $deviceService;
        $this->roomService = $roomService;
        $this->userService = $userService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
            $this->authorize('viewAny', Borrow::class);
            $items = $this->borrowService->paginate(20,$request);
            $users = User::orderBy('name')->get();
            $nests = Nest::orderBy('name')->get();
            // $users = $this->userService->all($request);
            return view('borrows.index', compact('items','request','users','nests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $this->authorize('create', Borrow::class);

        // dd($this->userService->get());
        $users = $this->userService->all($request);
        $rooms = $this->roomService->all($request);

        return view('borrows.create', compact('users', 'rooms'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBorrowRequest $request)
    {

        // dd(2);
        $data = $request->except(['_token', '_method']);
        $this->borrowService->store($data);
        return redirect()->route('borrows.index')->with('success', 'Thêm thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $item = $this->borrowService->find($id);
        $this->authorize('view', $item);
        $user = $item->user;
        $devices = $item->devices;
        $the_devices = $item->the_devices;
        return view('borrows.show', compact('item','user','devices','the_devices'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        // dd(1);
        $item = $this->borrowService->find($id);
        $this->authorize('update', $item);

        // $device_ids = [];
        // foreach ($item->the_devices as $device) {
        //     array_push($device_ids, $device->device_id);
        // }
        $device_ids = $item->the_devices->pluck('device_id')->toArray();
        $device_ids = json_encode($device_ids);
        // dd($device_ids);
        $users = User::all();
        $rooms = $this->roomService->all();

        return view('borrows.edit', compact('item','users','rooms','device_ids'));


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBorrowRequest $request, string $id)
    {
        $data = $request->except(['_token', '_method']);
        $this->borrowService->update( $data, $id);
        return redirect()->route('borrows.index')->with('success', 'Cập nhật thành công');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $borrow = $this->borrowService->find($id);
        $this->authorize('delete', $borrow);
        try {
            $borrow = $this->borrowService->find($id);


            $this->borrowService->destroy($id);

            return redirect()->route('borrows.index')->with('success', 'Xóa thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Xóa thất bại!');
        }
    }




    public function trash(Request $request)
    {

        $items = $this->borrowService->trash($request);
        $users = $this->userService->all($request);
        return view('borrows.trash', compact('items', 'users', 'request'));
    }

    public function restore($id)
    {
        $borrow = $this->borrowService->find($id);
        $this->authorize('restore', $borrow);
        try {
            // Khôi phục bản ghi mượn
            $this->borrowService->restore($id);

            // Lấy các thiết bị liên quan đến bản ghi mượn đã khôi phục
            $borrow = $this->borrowService->find($id);
            foreach ($borrow->the_devices as $device) {
                $this->deviceService->updateQuantity($device->device_id, -$device->quantity);
            }

            return redirect()->route('borrows.trash')->with('success', 'Khôi phục thành công');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('borrows.trash')->with('error', 'Khôi phục không thành công!');
        }
    }

    public function forceDelete($id)
    {
        $borrow = $this->borrowService->find($id);
        $this->authorize('forceDelete', $borrow);
        try {
            // Delete the record and related devices

            $this->borrowService->forceDelete($id);
            return redirect()->route('borrows.trash')->with('success', 'Xóa thành công');
        } catch (\exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('borrows.trash')->with('error', 'Xóa không thành công!');
        }
    }

    public function devices(Request $request)
    {
        $devices = $this->deviceService->paginate(2,$request);
        $data = [];
        foreach ($devices as $device){
            $data[] = [
                'id' => $device->id,
                'text' => $device->name . ' (Type: '. $device->devicetype->name .' - SL: '. $device->quantity.')',
                'disabled' => $device->quantity == 0 ? true : false
            ];
        }
        return response()->json($data);
    }

    public function updateBorrow(Request $request, $id)
    {
        // dd($request->status);
        $data = $request->all(); // Lấy dữ liệu từ biểu mẫu

        $this->borrowService->updateBorrow($id, $data); // Gọi phương thức để cập nhật

        return redirect()->back()->with('success', 'Cập nhật thành công');
    }

}
