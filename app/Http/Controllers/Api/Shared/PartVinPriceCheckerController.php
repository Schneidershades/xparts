<?php

namespace App\Http\Controllers\Api\Shared;

use App\Models\Vin;
use App\Models\Part;
use App\Models\Quote;
use App\Models\XpartRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Shared\StorePartVinPriceEstimateRequest;
use App\Models\PartGrade;

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
        
        $vin_number = $request['vin_number'];

        $part = Part::where('name', $part_name)->first();  

        $vinDetails = Vin::where('vin_number', $vin_number)->first();

        if(!$part && !$vinDetails){
            return $this->showMessage('we have no estimated price range for this part at the moment');
        }

        $getRelatedCarMakeIds = Vin::where('make', $vinDetails->make)->pluck('id')->toArray();
        
        $xpartRequests = XpartRequest::where('part_id', $part->id)->whereIn('vin_id', $getRelatedCarMakeIds)->pluck('id')->toArray();

        $partGrades = PartGrade::all();

        $message = null;

        foreach($partGrades as $grade){

            $quote_prices = Quote::where('part_grade_id', $grade->id)
                                ->whereIn('xpart_request_id', $xpartRequests)
                                ->pluck('markup_price')
                                ->toArray();

            if(count($quote_prices) == 1){
                
                $minPrice = $quote_prices[0];
                $maxPrice = $quote_prices[0] + 500;

                // $message = [
                //     'grade' => $grade->name,
                //     'min_price' => '(₦' . number_format($minPrice, 2, '.', ',') ,
                //     'max_price' => '(₦' . number_format($maxPrice, 2, '.', ',') ,

                // ];

                $message .= 'Price ranges for '. $grade->name .' (₦' . number_format($minPrice, 2, '.', ',') . ' - ₦' . number_format($maxPrice, 2, '.', ',') .') \n';

            }

            if(count($quote_prices) > 1){
                
                $minPrice = min($quote_prices);
                $maxPrice = max($quote_prices);

                // $message = [
                //     'grade' => $grade->name,
                //     'min_price' => '(₦' . number_format($minPrice, 2, '.', ',') ,
                //     'max_price' => '(₦' . number_format($maxPrice, 2, '.', ',') ,
                // ];

                $message .= 'Price ranges for '. $grade->name .' (₦' . number_format($minPrice, 2, '.', ',') . ' - ₦' . number_format($maxPrice, 2, '.', ',') .') \n';

            }    

            // if(count($quote_prices) == 0){
                
            //     $message = [
            //         'grade' => null,
            //         'min_price' => null ,
            //         'max_price' => null,
            //     ];
                
            // }    
        }

        return $this->showMessage($message);            
    }
}
