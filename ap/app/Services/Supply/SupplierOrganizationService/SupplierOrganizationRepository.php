<?php

namespace App\Services\Supply\SupplierOrganizationService;
// use App\Services\UserService\UserRepository; 
use App\Models\SupplierOrganization;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class SupplierOrganizationRepository 
{

    // protected $userRepository;

    // public function __construct(UserRepository $userRepository)
    // {
    //     $this->userRepository = $userRepository;
    // }

    public function index()
    {
       
        return SupplierOrganization::latest()->paginate(3);

    }
    public function create(array $data)
    {
       
        try {

            return SupplierOrganization::updateOrCreate(
                [
                    'supplier_id' => $data['supplier_id'],
                    'organization_id' => $data['organization_id']
                ],
                $data
            );

        } catch (QueryException $exception) {
            Log::channel('insertion_errors')->error('Error creating user: ' . $exception->getMessage());

            return response()->json(['message' => 'Insertion failed.'], 500);
        } 
      
    }

    public function findById($id)
    {
        return SupplierOrganization::find($id);
    }

    public function update($id, array $data)
    {
        $SupplierOrganization = $this->findById($id);
      
        if ($SupplierOrganization) {

            $SupplierOrganization->update($data);
        }
        return $SupplierOrganization;
    }

    public function delete($id)
    {
        $SupplierOrganization = $this->findById($id);
        if ($SupplierOrganization) {
            return $SupplierOrganization->delete();
        }
        return null;
    }
    public function updateSupplierStatus($organization_id, $supplier_id)
    {
        $SupplierOrganization = SupplierOrganization::where([['supplier_id', $supplier_id],['organization_id', $organization_id]])->first();
       
        if ($SupplierOrganization) {
            
            $SupplierOrganization->update([
                'status'=>1
            ]);
           
        }
        return $SupplierOrganization;
    }

}
