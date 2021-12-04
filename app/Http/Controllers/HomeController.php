<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\teacher;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('index');
    }
    
    // all data
    public function alldata(){
        $data = teacher::orderBy('id')->get();
        return response()->json($data);
    }

    // store data
    public function storedata(Request $request){
         $request->validate([
             'name' => 'required',
             'title' => 'required',
             'institute' => 'required',
         ]);
        $data = teacher::insert([
             'name' => $request->name,
             'title' => $request->title,
             'institute'=> $request->institute,

        ]);
        return response()->json($data);
    }

    public function editData($id){
        $data = Teacher::findOrFail($id);
        return response()->json($data);
    }

    public function updatedata(Request $request, $id){
        $request->validate([
            'name' => 'required',
            'title' => 'required',
            'institute' => 'required',
        ]);

        $data = teacher::findOrFail($id)->update([
            'name' => $request->name,
            'title' => $request->title,
            'institute'=> $request->institute,
       ]);

       return response()->json($data);
    }

    public function deletedata($id){
        $data = teacher::findOrFail($id);
        $data->delete();
        return response()->json(['success' => 'data has been deleted succesfully']);
    }
    
}

