<?php

namespace App\Http\Controllers\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductTypeFormRequest;
use App\Services\Products\ProductTypeService\ProductTypeService;
use Illuminate\Http\Request;
use App\Services\FileUploadService;


class ProductTypeController extends Controller
{
     protected $productTypeService;
     protected $fileUploadService;

    public function __construct(ProductTypeService $productTypeService, FileUploadService $fileUploadService)
    {
        $this->productTypeService = $productTypeService;
        $this->fileUploadService = $fileUploadService;
    }
    public function index()
    {
        
        $productType = $this->productTypeService->index();
        return response()->json($productType);
    }

    public function store(ProductTypeFormRequest $request)
    {
        $data = $request->all();

        if ($request->hasFile('product_type_image')) {
            $data['product_type_image'] = $this->fileUploadService->uploadImage($request->file('product_type_image'),'product_type');
        }
        return $this->productTypeService->create($data);
       
    }

    public function show($id)
    {
        $productType = $this->productTypeService->show($id);
        return response()->json($productType);
    }

    public function update($id, Request $request)
    {
        $data = $request->all();
       
        if ($request->hasFile('product_type_image')) {

            $data['product_type_image'] = $this->fileUploadService->uploadImage($request->file('product_type_image'),'product_type');
           
        }
       
        return $this->productTypeService->update($id,  $data);
       
    }

    public function destroy($id)
    {
        return $this->productTypeService->deleteProduct($id);
       
    }
}
