<?php

namespace App\Http\Controllers;

use App\Models\SimpleCrud;
use App\Http\Requests\StoreSimpleCrudRequest;
use App\Http\Requests\UpdateSimpleCrudRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class SimpleCrudController extends Controller
{
    public function index()
    {
        $data = Cache::remember("cache",60*60*24, function(){
            return SimpleCrud::all();
        });

        if ($data->isNotEmpty()) {
            return [
                'status' => 201,
                'success' => true,
                'message' => 'Data Found',
                'data' => $data
            ];
        } else {
            return [
                'status' => 200,
                'success' => false,
                'message' => 'Data not found',
            ];
        }
        
    }

    public function store(StoreSimpleCrudRequest $request)
    {
        try {
            $image = $request->file('image');
            Storage::disk('local')->put('public/store', $image);
            SimpleCrud::create($request->validated());
            return [
                'status' => 201,
                'success' => true,
                'message' => 'Data insert Successfully'
            ];
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

    public function show(SimpleCrud $simple)
    {
        return [
            'status' => 201,
            'success' => true,
            'message' => 'Data Found',
            'data' => $simple
        ];
    }

    public function update(UpdateSimpleCrudRequest $request, SimpleCrud $simple)
    {
        try {
            $simple->update($request->validated());
            return [
                'status' => 201,
                'success' => true,
                'message' => 'Data update Successfully'
            ];
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

    public function archive()
    {
        $trashData = SimpleCrud::onlyTrashed()->orderBy('deleted_at','desc')->get();
        if ($trashData->isNotEmpty()) {
            return [
                'status' => 201,
                'success' => true,
                'message' => 'Data Found',
                'data' => $trashData
            ];
        } else {
            return [
                'status' => 200,
                'success' => false,
                'message' => 'Data not found'
            ];
        }
    }

    public function destroy(SimpleCrud $simple)
    {
        $simple->delete();
        return [
            'status' => 201,
            'success' => true,
            'message' => 'Data deleted temporarily'
        ];
    }

    public function permanentDelete($simple)
    {
        SimpleCrud::where('id',$simple)->withTrashed()->forceDelete();
        return [
            'status' => 201,
            'success' => true,
            'message' => 'Data deleted Permanently'
        ];
    }

    public function restore($simple)
    {
        SimpleCrud::where('id',$simple)->withTrashed()->restore();
        return [
            'status' => 201,
            'success' => true,
            'message' => 'Data restore Successfully'
        ];
    }
}
