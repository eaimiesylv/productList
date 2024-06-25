<?php

namespace App\Http\Controllers\Inventory;
use App\Http\Controllers\Controller;
use App\Services\Inventory\SaleService\SaleService;
use Illuminate\Http\Request;
use Exception;

class SearchSaleController extends Controller
{
    protected $saleService;

    public function __construct(SaleService $saleService)
    {
        $this->saleService = $saleService;
    }
 

    public function show($id)
    {
        $sale = $this->saleService->searchSale($id);
        return response()->json($sale);
    }

   
}
