<?php

namespace App\Services\Tested\MediaService;

use App\Models\Media;

use Exception;

class MediaRepository
{
    public function index()
    {
        return Media::all();
    }

    public function show($id)
    {
        return Media::where('id',$id)->first();
    }

    public function store($data)
    {
       // try {
            return Media::create($data);
        // } catch (Exception $e) {
        //    // Log::channel('insertion_errors')->error('Error creating or updating user: ' . $e->getMessage());
        //     return response()->json([
        //         'success' => 'false',
        //         'message' => 'Insertion error'
        //     ], 500);
        // }
        
    }

    public function update($data, $id)
    {
        try {  
        $model = Media::where('id',$id)->first();
            if($model){
                $model->update($data);
            }
            return $model;
        } catch (Exception $e) {
            Log::channel('insertion_errors')->error('Error creating or updating user: ' . $e->getMessage());
            return response()->json([
                'success' => 'false',
                'message' => 'Insertion error'
            ], 500);
        }
    }   

    public function destroy($id)
    {
        try { 
            $model = Media::where('id',$id)->first();
            $model->delete();
            return $model;
        } catch (Exception $e) {
            Log::channel('insertion_errors')->error('Error creating or updating user: ' . $e->getMessage());
            return response()->json([
                'success' => 'false',
                'message' => 'Insertion error'
            ], 500);
        }
    }
}
