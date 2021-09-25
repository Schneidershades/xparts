<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Models\PartSpecialization;
use App\Http\Controllers\Controller;

class PartSpecializationController extends Controller
{
     /**
    * @OA\Get(
    *      path="/api/v1/admin/part-specialization",
    *      operationId="allPartSpecialization",
    *      tags={"Admin"},
    *      summary="allPartSpecialization",
    *      description="allPartSpecialization",
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
        $this->showAll(PartSpecialization::all());
    }
}
