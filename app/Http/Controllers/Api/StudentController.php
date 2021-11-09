<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator; 
use App\Models\Students;

class StudentController extends Controller
{
    //
    public function index() 
    {
        $students = Students::all();
        
        if (count($students) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $students
            ], 200);
        }

        return response ([
            'message' => 'Empty',
            'data' => null
        ], 400);
    }

    
    public function show($id)
    {
        $Students = Students::find($id);

        if(!is_null($Students)){
            return response([
                'message' => 'Retrieve Student Success',
                'data' => $Students
            ], 200);
        }

        return response ([
            'message' => 'Student Not Found',
            'data' => null
        ], 404);
    }


    public function store (Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'nama_murid' => 'required|regex:/^[\pL\s\-]+$/u',
            'npm' => 'required|numeric',
            'tanggal_lahir' => 'required|date',
            'no_telp' => 'required|numeric|digits_between:10,13|starts_with:08'
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $Students = Students::create($storeData);
        return response([
            'message' => 'Add Student Success',
            'data' => $Students
        ], 200);
    }


    public function destroy($id)
    {
        $Students = Students::find($id);

        if(is_null($Students)) {
            return response([
                'message' => 'Student Not Found',
                'data' => null
            ], 404);
        }

        if($Students->delete()) {
            return response([
                'message' => 'Delete Student Success',
                'data' => $Students
            ], 200);
        }

        return response([
            'message' => 'Delete Student Failed',
            'data' => null
        ], 400);
    }


    public function update(Request $request, $id)
    {
        $Students = Students::find($id);
        if(is_null($Students)){
            return response([
                'message' => 'Student Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'nama_murid' => 'required|regex:/^[\pL\s\-]+$/u',
            'npm' => 'required|numeric',
            'tanggal_lahir' => 'required|date',
            'no_telp' => 'required|numeric|digits_between:10,13|starts_with:08'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $Students->nama_murid = $updateData['nama_murid'];
        $Students->npm = $updateData['npm'];
        $Students->tanggal_lahir = $updateData['tanggal_lahir'];
        $Students->no_telp = $updateData['no_telp'];

        if($Students->save()){
            return response([
                'message' => 'Update Student Success',
                'data' => $Students
            ], 200);
        }
        return response([
            'message' => 'Update Student Failed',
            'data' => null
        ], 400);
    }
}
