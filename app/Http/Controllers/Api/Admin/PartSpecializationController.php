<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\PartSpecialization;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PartSpecializationCreateFormRequest;
use App\Http\Requests\Admin\PartSpecializationUpdateFormRequest;

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
        return $this->showAll(PartSpecialization::all());
    }
    
    /**
    * @OA\Post(
    *      path="/api/v1/admin/part-specialization",
    *      operationId="postPartSpecialization",
    *      tags={"Admin"},
    *      summary="postPartSpecialization",
    *      description="postPartSpecialization",
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/PartSpecializationCreateFormRequest")
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
    public function store(PartSpecializationCreateFormRequest $request)
    {
        return $this->showOne(PartSpecialization::create($request->validated()));
    }

    /**
    * @OA\Get(
    *      path="/api/v1/admin/part-specialization/{id}",
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
        return $this->showOne(PartSpecialization::findOrFail($id));
    }

    /**
    * @OA\Put(
    *      path="/api/v1/admin/part-specialization/{id}",
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
    *          @OA\JsonContent(ref="#/components/schemas/PartSpecializationUpdateFormRequest")
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
    
    public function update(PartSpecializationUpdateFormRequest $request, PartSpecialization $vehicleSpecialization)
    {
        return $this->showOne(PartSpecialization::find($vehicleSpecialization)->update($request->validated()));
    }

     /**
    * @OA\Delete(
    *      path="/api/v1/admin/part-specialization/{id}",
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
    public function destroy(PartSpecialization $partSpecialization)
    {
        $partSpecialization->delete();
        return $this->showMessage('deleted');
    }
}
