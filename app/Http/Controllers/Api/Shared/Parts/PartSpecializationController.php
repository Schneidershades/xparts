<?php

namespace App\Http\Controllers\Api\Shared\Parts;

use App\Http\Controllers\Controller;
use App\Models\PartSpecialization;

class PartSpecializationController extends Controller
{
    /**
    * @OA\Get(
    *      path="/api/v1/shared/part-specialization",
    *      operationId="partSpecialization",
    *      tags={"Shared"},
    *      summary="partSpecialization",
    *      description="partSpecialization",
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
        return $this->showAll(PartSpecialization::all());
    }
}
