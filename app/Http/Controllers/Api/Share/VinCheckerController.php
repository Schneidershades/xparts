<?php

namespace App\Http\Controllers\Api\Share;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Plugins\VinChecker;

class VinCheckerController extends Controller
{

    /**
    * @OA\Post(
    *      path="/api/v1/check/vin",
    *      operationId="checkVin",
    *      tags={"Share"},
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
        $checkerApi = new VinChecker();
        // check if the API is already in our database;
        
        return $checkerApi->sendVin($request->vin_number);
    }
}
