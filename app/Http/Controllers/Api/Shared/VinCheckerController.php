<?php

namespace App\Http\Controllers\Api\Shared;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Plugins\VinChecker;
use App\Models\Vin;

class VinCheckerController extends Controller
{
    /**
    * @OA\Post(
    *      path="/api/v1/shared/check-vin",
    *      operationId="checkVin",
    *      tags={"Shared"},
    *      summary="checkVin",
    *      description="checkVin",
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/VinCheckerFormRequest")
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
    public function __invoke(Request $request)
    {
        $vin = Vin::where('vin_number', $request->vin_number)->first();

        $checkerApi = new VinChecker();

        if(!empty($vin) && $vin->admin_attention == true){

            $vinResponse = $checkerApi->sendVin($request->vin_number);

            $model = $this->contentAndDbIntersection($vinResponse, $vin, [], [
                'admin_attention' => 0, 
                'remarks' => 'Found',
                'verified' => true,
            ]);

            $model->save();

            $vin = Vin::where('vin_number', $request->vin_number)->first();            
            $vin->search_count += 1;
            $vin->save();
            return $this->showOne($vin);
        }elseif(!empty($vin) && $vin->admin_attention == false){           
            $vin->search_count += 1;
            $vin->save();
            return $this->showOne($vin);
        }else{
            
            $vinResponse = $checkerApi->sendVin($request->vin_number);

            if($vinResponse == null || $vinResponse == []){

                $vin = new Vin;
                $vin->vin_number = $request['vin_number'];
                $vin->admin_attention = 1;
                $vin->search_count = 1;
                $vin->save();
                return $this->showOne($vin);
                
            }else{
                if($vin == null){
                    $model = new Vin;
                }else{
                    $model = Vin::where('vin_number', $request->vin_number)->first();
                }

                $model = $this->contentAndDbIntersection($vinResponse, $model, [], [
                    'admin_attention' => 0, 
                    'remarks' => 'Found',
                    'verified' => true,
                ]);

                $model->save();

                $vin = Vin::where('vin_number', $request->vin_number)->first();

                return $this->showOne($vin);
            }
        }        
    }
}
