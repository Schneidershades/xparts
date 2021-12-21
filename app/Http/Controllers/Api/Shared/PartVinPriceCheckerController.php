<?php

namespace App\Http\Controllers\Api\Shared;

use App\Models\Part;
use App\Models\Quote;
use App\Models\XpartRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Shared\StorePartVinPriceEstimateRequest;

class PartVinPriceCheckerController extends Controller
{
    /**
    * @OA\Post(
    *      path="/api/v1/shared/check-part-vin-price-estimates",
    *      operationId="checkVin",
    *      tags={"Shared"},
    *      summary="checkVin",
    *      description="checkVin",
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/StorePartVinPriceEstimateRequest")
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
    public function __invoke(StorePartVinPriceEstimateRequest $request)
    {
        $part_name = $request['part_name'];

        $part = Part::where('name', $part_name)->first();  
        
        $xpartRequests = XpartRequest::where('part_id', $part->id)->get();

        if(!$xpartRequests){
            return $this->showMessage('we have no estimated price range for this part at the moment');
        }
        
        $xpartRequests = $xpartRequests->pluck('id')->toArray();

        $quote_prices = Quote::whereIn('xpart_request_id', $xpartRequests)->pluck('markup_price')->toArray();

        if(count($quote_prices) == 0){
            return $this->showMessage('we have no estimated price range for this part');
        }

        if(count($quote_prices) == 1){
            return $this->showMessage('Price estimated starts from' . $quote_prices[0]);
        }

        if(count($quote_prices) > 1){
            $minPrice = min($quote_prices);
            $maxPrice = max($quote_prices);
            return $this->showMessage('Price estimated starts from ' . $minPrice . ' - ' . $maxPrice);
        }        
    }
}
