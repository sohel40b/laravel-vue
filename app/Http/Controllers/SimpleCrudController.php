<?php

namespace App\Http\Controllers;

use App\Models\SimpleCrud;
use App\Http\Requests\StoreSimpleCrudRequest;
use App\Http\Requests\UpdateSimpleCrudRequest;
use Illuminate\Support\Facades\Log;

class SimpleCrudController extends Controller
{
    public function index()
    {
        $data = SimpleCrud::all();
        if ($data == null) {
            return [
                'status' => 200,
                'success' => false,
                'message' => 'Data not found',
            ];
        } else {
            return [
                'status' => 201,
                'success' => true,
                'message' => 'Data Found',
                'data' => $data
            ];
        }
    }

    public function store(StoreSimpleCrudRequest $request)
    {
        try {
            $dataCheck = SimpleCrud::create($request->validated());
            if ($dataCheck == null) {
                return [
                    'status' => 200,
                    'success' => false,
                    'message' => 'Data not found'
                ];
            } else {
                return [
                    'status' => 201,
                    'success' => true,
                    'message' => 'Data insert Successfully'
                ];
            }
        } catch (\Exception $e) {
            $exception = $e->getMessage();
            Log::channel('developer')->info("Create Error ===> ".$exception);
            return [
                'status' => 500,
                'success'   => false,
                'message'   => 'Something Want Wrong!'
            ];
        }
    }

    public function show($id)
    {
        $simpleCrud = SimpleCrud::where('id',$id)->first();
        if ($simpleCrud == null) {
            return [
                'status' => 200,
                'success' => false,
                'message' => 'Data not found',
            ];
        } else {
            return [
                'status' => 201,
                'success' => true,
                'message' => 'Data Found',
                'data' => $simpleCrud
            ];
        }
    }

    public function update(UpdateSimpleCrudRequest $request, $id)
    {
        try {
            $dataUpdate = SimpleCrud::find($id);
            if ($dataUpdate == null) {
                return [
                    'status' => 200,
                    'success' => false,
                    'message' => 'Data not found'
                ];
            } else {
                $dataUpdate->update($request->validated());
                return [
                    'status' => 201,
                    'success' => true,
                    'message' => 'Data update Successfully'
                ];
            }
        } catch (\Exception $e) {
            $exception = $e->getMessage();
            Log::channel('developer')->info("Update Error ===> ".$exception);
            return [
                'status' => 500,
                'success'   => false,
                'message'   => 'Something Want Wrong!'
            ];
        }
    }

    public function destroy($id)
    {
        $data = SimpleCrud::find($id)->delete();
        if ($data == null) {
            return [
                'status' => 200,
                'success' => false,
                'message' => 'Data not found'
            ];
        } else {
            return [
                'status' => 201,
                'success' => true,
                'message' => 'Data delete Successfully'
            ];
        }
    }
}
