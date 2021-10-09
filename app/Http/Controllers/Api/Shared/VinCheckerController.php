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

        $vin = Vin::where('vin_number', $request['vin_number'])->first();

        dd($vin);

        if($vin == null){
            $checkerApi = new VinChecker();
            $vinResponse =  $checkerApi->sendVin($request['vin_number']);
            
            $vin = new Vin;
            $vin = $this->contentAndDbIntersection($vinResponse, $vin);
            $vin->save();
        }else{
            $vin->search_count = $vin->search_count + 1;
            $vin->save();
            return $this->showOne($vin);
        }

        $vin = Vin::where('vin_number', $request['vin_number'])->first();
        return $this->showOne($vin);

    }
}
