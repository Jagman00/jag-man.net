<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jobs;
use DataTables;
use Illuminate\Support\Facades\DB;

class JobTableController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = DB::select('SELECT jobs.* , users.steam_id, users.name FROM jobs INNER JOIN users ON jobs.steamid COLLATE utf8mb4_0900_ai_ci = users.steam_id');
                    
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('jobs');
    
    }

        
}
