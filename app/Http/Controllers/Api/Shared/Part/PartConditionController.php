<?php

namespace App\Http\Controllers\Api\Shared\Part;

use App\Http\Controllers\Controller;
use App\Models\PartCondition;

class PartConditionController extends Controller
{
     /**
    * @OA\Get(
    *      path="/api/v1/shared/part-condition",
    *      operationId="allPartCondition",
    *      tags={"Shared"},
    *      summary="allPartCondition",
    *      description="allPartCondition",
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
    public function index()
    {
        return $this->showAll(PartCondition::all());
    }
}
