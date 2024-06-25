<?php

namespace App\Http\Controllers\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductFormRequest;
use App\Services\Products\ProductService\ProductService;
use App\Services\Products\ProductTypeService\ProductTypeService;
use Illuminate\Http\Request;
use App\Services\FileUploadService;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
     protected $productService;
     protected $fileUploadService;
     protected $productTypeService;

    public function __construct(ProductService $productService, FileUploadService $fileUploadService, ProductTypeService $productTypeService)
    {
        $this->productService = $productService;
        $this->productTypeService = $productTypeService;
        $this->fileUploadService = $fileUploadService;
    }
    public function index()
    {
        $product = \App\Models\Product::all();
        return response()->json($product);
    }

    
    public function store(ProductFormRequest $request)
{
    DB::beginTransaction(); // Start the transaction

    try {
        $product = \App\Models\Product::create($request->validated());

        DB::commit(); // Commit the transaction

    return response()->json(['data' => $product, 'message' =>'Product created successfully'], 201);
    } catch (\Exception $e) {
        DB::rollBack(); // Rollback the transaction on any error
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

    public function show($id)
    {
        $product = $this->productService->getProductById($id);
        return response()->json($product);
    }

    public function update($id, Request $request)
    {
        $data = $request->all();
       
        if ($request->hasFile('product_image')) {
            $data['product_image'] = $this->fileUploadService->uploadImage($request->file('product_image'),'products');
        }
        return  $this->productService->updateProduct($id, $data);
       
    }

    public function destroy($id)
    {
        return $this->productService->deleteProduct($id);
       
    }
}
