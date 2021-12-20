<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Models\Pengunjung;

class PengunjungController extends Controller
{
    //
    public function index() 
    {
        $pengunjungs = Pengunjung::all();
        
        if (count($pengunjungs) > 0) {
            return response ([
                'message' => 'Retrieve All Success',
                'data' => $pengunjungs
            ], 200);
        }

        return response ([
            'message' => 'Empty',
            'data' => null
        ], 400);
    }

    
    public function show($id)
    {
        $pengunjung = Pengunjung::find($id);

        if(!is_null($pengunjung)) {
            return response ([
                'message' => 'Retrieve Pengunjung Success',
                'data' => $pengunjung
            ], 200);
        }

        return response ([
            'message' => 'Pengunjung Not Found',
            'data' => null
        ], 404);
    }


    public function store (Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'nama_pengunjung' => 'required|max:60|unique:pengunjungs',
            'email'=> 'required',
            'review' => 'required',
            
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $pengunjung = Pengunjung::create($storeData);
        return response([
            'message' => 'Add Pengunjung Success',
            'data' => $pengunjung
        ], 200);
    }


    public function destroy($id)
    {
        $pengunjung = Pengunjung::find($id);

        if(is_null($pengunjung)) {
            return response ([
                'message' => 'Pengunjung Not Found',
                'data' => null
            ], 400);
        }

        if ($pengunjung->delete()) {
            return response ([
                'message' => 'Delete Pengunjung Success',
                'data' => $pengunjung
            ], 200);
        }

        return response ([
            'message' => 'Delete Pengunjung Failed',
            'data' => null, 
        ], 400);
    }


    public function update(Request $request, $id)
    {
        $pengunjung = Pengunjung::find($id);
        if(is_null($pengunjung)) {
            return response ([
                'message' => 'Pengunjung Not Found',
                'data' => null
            ], 400);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [


            'nama_pengunjung' => ['max:60', 'required', Rule::unique('pengunjungs')->ignore($pengunjung)],
            'email'=> 'required',
            'review' => 'required',
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $pengunjung->nama_pengunjung = $updateData ['nama_pengunjung'];
        $pengunjung->email = $updateData ['email'];
        $pengunjung->review = $updateData ['review'];

        if($pengunjung->save()) {
            return response ([
                'message' => 'Update Pengunjung Success',
                'data' => null,
            ], 200);
        }
        return response ([
            'message' => 'Update Pengunjung Failed',
            'data' => null,
        ], 400);
    }
}
