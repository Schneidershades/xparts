<?php

namespace App\Http\Controllers\Api\Shared\Vehicle;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\VehicleSpecialization;

class VehicleSpecializationController extends Controller
{
    /**
    * @OA\Get(
    *      path="/api/v1/shared/vehicle-specialization",
    *      operationId="vehicleSpecialization",
    *      tags={"Shared"},
    *      summary="vehicleSpecialization",
    *      description="vehicleSpecialization",
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
        return $this->showAll(VehicleSpecialization::all());
    }
}
