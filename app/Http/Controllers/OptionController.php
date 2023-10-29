<?php

namespace App\Http\Controllers;
use App\Models\Option;
use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;

class OptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('update', Option::class);
        $group_labels=[
            'general'=>'Cấu hình chung',
            'mail'=>'Cấu hình mail',
        ];
        $options = Option::all();
        $all_options = [];
        foreach ($options as $option){
            $all_options[$option->option_group][] = $option;
        }
        // dd($all_options);
        return view('options.index', compact('all_options','group_labels'));
    }


    public function update(Request $request)
    {
        $data = $request->except(['_token', '_method']);
        foreach ($data as $option_name => $option_value){
            Option::where('option_name',$option_name)->update([
                'option_value'=> $option_value
            ]);
        }
        return redirect()->route('options.index')->with('success', 'Cập Nhật thành công!');
    // $option = Option::findOrFail($id);
    // $option->option_value = $request->input($option->option_name);
    // $option->save();
    // return redirect()->route('options.index')->with('success', 'Cập nhật tùy chọn thành công');
    }

}
