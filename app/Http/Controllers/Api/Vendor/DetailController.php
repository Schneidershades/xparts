<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Models\Bank;
use App\Models\User;
use App\Models\Address;
use App\Models\BankDetail;
use App\Traits\Payment\Paystack;
use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\DetailCreateFormRequest;

class DetailController extends Controller
{
    /**
    * @OA\Post(
    *      path="/api/v1/vendor/business-details",
    *      operationId="postVendorBusinessDetails",
    *      tags={"Vendor"},
    *      summary="postVendorBusinessDetails",
    *      description="postVendorBusinessDetails",
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/DetailCreateFormRequest")
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="Successful signin",
    *          @OA\MediaType(
    *             mediaType="application/json",
    *         ),
    *       ),
    *      @OA\Response(
    *          response=400,
    *          description="Bad Request"
    *      ),
    *      @OA\Response(
    *          response=401,
    *          description="unauthenticated",
    *      ),
    *      @OA\Response(
    *          response=403,
    *          description="Forbidden"
    *      ),
    *      security={ {"bearerAuth": {}} },
    * )
    */
    
    public function store(DetailCreateFormRequest $request)
    {
        $address = Address::where('user_id', auth()->user()->id)->first();
        $bankDetail = BankDetail::where('user_id', auth()->user()->id)->first();
        $bank = Bank::where('id', $request['bank_id'])->first();
        $array = ['user_id' => auth()->user()->id];
        $user = User::find(auth()->user()->id);

        $user->assignRole('Vendor');

        $paystack = new Paystack;
        
        $verifiedBank = $paystack->resolveBank($request['bank_account_number'], $bank);

        if ($verifiedBank['status'] == false) {
            return $this->errorResponse($verifiedBank['message'], 400);
        }

        if($address == null){
            $address = new Address;
            $address = $this->requestAndDbIntersection($request, $address, [], $array);
            $address->save();
        }else{
            $address = $this->requestAndDbIntersection($request, $address, [], $array);
            $address->save();
        }
        
        if($bankDetail == null){
            $bankDetail = new BankDetail;
            $bankDetail = $this->contentAndDbIntersection($verifiedBank, $bankDetail, [], $array);
            $bankDetail->save();
        }else{
            $bankDetail = $this->contentAndDbIntersection($verifiedBank, $bankDetail, [], $array);
            $bankDetail->save();
        }

        return $this->showMessage('Details saved');
    }
}
