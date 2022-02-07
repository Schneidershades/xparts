<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\VehicleSpecialization;
use App\Http\Requests\Admin\VehicleSpecializationCreateFormRequest;
use App\Http\Requests\Admin\VehicleSpecializationUpdateFormRequest;

class VehicleSpecializationController extends Controller
{
     /**
    * @OA\Get(
    *      path="/api/v1/admin/vehicle-specialization",
    *      operationId="allVehicleSpecialization",
    *      tags={"Admin"},
    *      summary="allVehicleSpecialization",
    *      description="allVehicleSpecialization",
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

    /**
    * @OA\Post(
    *      path="/api/v1/admin/vehicle-specialization",
    *      operationId="postVehicleSpecialization",
    *      tags={"Admin"},
    *      summary="postVehicleSpecialization",
    *      description="postVehicleSpecialization",
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/VehicleSpecializationCreateFormRequest")
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
    public function store(VehicleSpecializationCreateFormRequest $request)
    {
        return $this->showOne(VehicleSpecialization::create($request->validated()));
    }

    /**
    * @OA\Get(
    *      path="/api/v1/admin/vehicle-specialization/{id}",
    *      operationId="showVehicleSpecialization",
    *      tags={"Admin"},
    *      summary="showVehicleSpecialization",
    *      description="showVehicleSpecialization",
    *
     *      @OA\Parameter(
     *          name="id",
     *          description="showVehicleSpecialization ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *
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
    public function show($id)
    {
        return $this->showOne(VehicleSpecialization::findOrFail($id));
    }

    /**
    * @OA\Put(
    *      path="/api/v1/admin/vehicle-specialization/{id}",
    *      operationId="updateVehicleSpecialization",
    *      tags={"Admin"},
    *      summary="updateVehicleSpecialization",
    *      description="updateVehicleSpecialization",
    *
     *      @OA\Parameter(
     *          name="id",
     *          description="updateVehicleSpecialization ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/VehicleSpecializationUpdateFormRequest")
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

    public function update(VehicleSpecializationUpdateFormRequest $request, VehicleSpecialization $vehicleSpecialization)
    {
        return $this->showOne(VehicleSpecialization::find($vehicleSpecialization)->update($request->validated()));
    }

     /**
    * @OA\Delete(
    *      path="/api/v1/admin/vehicle-specialization/{id}",
    *      operationId="deleteVehicleSpecialization",
    *      tags={"Admin"},
    *      summary="deleteVehicleSpecialization",
    *      description="deleteVehicleSpecialization",
    *
     *      @OA\Parameter(
     *          name="id",
     *          description="deleteVehicleSpecialization ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
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
    public function destroy(VehicleSpecialization $vehicleSpecialization)
    {
        $vehicleSpecialization->delete();
        return $this->showMessage('deleted');
    }
}
