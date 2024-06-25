<?php

namespace App\Services\Inventory\PriceService;

use App\Models\PriceNotification;
use App\Models\Price;
use App\Models\Store;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class PriceNotificationRepository 
{
    public function index()
    {
        //if(auth()->user()->type_id < 3){
        $priceNotification= PriceNotification::select('id','product_type_id','supplier_id','cost_price','selling_price','status')
                                  ->with('productTypes:id,product_type_name,product_type_image',
                                         'supplier:id,first_name,last_name,contact_person,phone_number')
                                         ->latest()
                                         ->paginate(20);

                                         $priceNotification->getCollection()->transform(function ($Price) {
                                            return $this->transformProduct($Price);
                                        });
                                

                                         return  $priceNotification;
       // }
        
        
    }

    private function transformProduct($price){

        return [
            'id' => $price->id,
            'product_type_name' => optional($price->productTypes)->product_type_name,
            'product_type_image' => optional($price->productTypes)->product_type_image,
            'product_type_description' => optional($price->productTypes)->product_type_description,
            'cost_price' => $price->cost_price,
            'selling_price' => $price->selling_price,
            'status' => $price->status,
            'supplier_detail' =>  optional($price->supplier)->first_name." ".optional($price->supplier)->last_name." ".  optional($price->supplier)->contact_person,
            'supplier_phone_number' => optional($price->supplier)->phone_number
          
        ];

    }

    public function create(array $data)
    {
        return PriceNotification::UpdateOrCreate(
            [
                'supplier_id' => $data['supplier_id'],
            'product_type_id' => $data['product_type_id']
            ],$data); 


    }
    

    public function show($id)
    {
        return PriceNotification::find($id);
    }
    
    public function update($id, array $data)
 {
    $priceNotification = PriceNotification::find($id);

    if ($priceNotification) {
        // Update the price notification
        $priceNotification->update($data);
        $batchNo = NULL;
        if ($data['status'] == 'accepted') {
            // 1. get the last price detail
            $lastPrice = Price::where('supplier_id', $priceNotification->supplier_id)
            ->where('product_type_id', $priceNotification->product_type_id)
            ->orderBy('created_at', 'desc')
            ->first();

            // check qty left
            $store = DB::table('stores')
                ->where('product_type_id', $priceNotification->product_type_id)
                ->where('batch_no', $lastPrice->batch_no)
                ->first();


            if ($store && $store->quantity_available > 1) {
                $newCostPrice = $lastPrice->cost_price ?? $priceNotification->cost_price;
                $newSellingPrice = $priceNotification->selling_price;
                $isNew = 1;
                $batchNo=$lastPrice->batch_no;
            } else {
                $newCostPrice = null;
                $newSellingPrice = null;
                $isNew = 0;
            }

            // Set previous prices to inactive
            Price::where('supplier_id', $priceNotification->supplier_id)
                ->where('product_type_id', $priceNotification->product_type_id)
                ->update(['status' => 0,'is_new' => 0]);

            // create a new active price
            Price::create([
                'supplier_id' => $priceNotification->supplier_id,
                'product_type_id' => $priceNotification->product_type_id,
                'status' => 1,
                'cost_price' => $priceNotification->cost_price,
                'selling_price' => $priceNotification->selling_price,
                'new_cost_price' => $newCostPrice,
                'new_selling_price' => $newSellingPrice,
                'is_new' => $isNew,
                'batch_no' => $batchNo,
                'currency_id' => $data['currency_id'] ?? null,
                'organization_id' => $data['organization_id'] ?? null,
                'created_by' => $data['created_by'] ?? auth()->id(),
                'updated_by' => $data['updated_by'] ?? auth()->id()
            ]);
        }
    }

    return $priceNotification;
        // Update the price notification
        
}

 

    public function delete($id)
    {
        $Price = PriceNotification::find($id);
        if ($Price) {
            
            return $Price->delete();
        }
      
    }
}
