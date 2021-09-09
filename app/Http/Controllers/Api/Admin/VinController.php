<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Vin;
use App\Http\Controllers\Controller;

class VinController extends Controller
{

    /**
    * @OA\Get(
    *      path="/api/v1/admin/vins",
    *      operationId="allVins",
    *      tags={"Admin"},
    *      summary="getVins",
    *      description="getVins",
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
        return $this->showAll(Vin::all());
    }
}
