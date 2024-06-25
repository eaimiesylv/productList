<?php

namespace App\Http\Controllers\Tested;
use App\Http\Controllers\Controller;
use App\Services\Tested\MediaService\MediaService;
use App\Http\Requests\Tested\MediaFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\FileUploadService;

class MediaController extends Controller
{
    private $mediaService;
    protected $fileUploadService;



    public function __construct(MediaService $mediaService, FileUploadService $fileUploadService)
    {
        $this->mediaService = $mediaService;
        $this->fileUploadService = $fileUploadService;
    }

    public function index()
    {
        $product = \App\Models\Media::all();
        return response()->json($product);
    }

    public function show($id)
    {
        return $this->mediaService->show($id);
    }

    public function store(MediaFormRequest $request)
    {
       
        $data = $request->all();

        if ($request->hasFile('media_name')) {
            $data['media_name'] = $this->fileUploadService->uploadImage($request->file('media_name'),'media');
        }
        return $this->mediaService->store($data);
    }

    public function update(MediaFormRequest $request, $id)
    {
        return $this->mediaService->update($request->all(), $id);
    }

    public function destroy($id)
    {
        return $this->mediaService->destroy($id);
    }
}