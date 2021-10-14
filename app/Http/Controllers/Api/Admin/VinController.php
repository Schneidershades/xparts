<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Vin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VinCreateFormRequest;
use App\Http\Requests\Admin\VinUpdateFormRequest;
use App\Http\Requests\Admin\UserUpdateFormRequest;

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
        return $this->showAll(Vin::latest()->get());
    }

    /**
    * @OA\Post(
    *      path="/api/v1/admin/vin",
    *      operationId="postVin",
    *      tags={"Admin"},
    *      summary="postVin",
    *      description="postVin",
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/VinCreateFormRequest")
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
    public function store(VinCreateFormRequest $request)
    {
        return $this->showOne(Vin::create($request->validated()));
    }

    /**
    * @OA\Get(
    *      path="/api/v1/admin/vin/{id}",
    *      operationId="showVin",
    *      tags={"Admin"},
    *      summary="showVin",
    *      description="showVin",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="showVin ID",
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
        return $this->showOne(Vin::findOrFail($id));
    }

    /**
    * @OA\Put(
    *      path="/api/v1/admin/vin/{id}",
    *      operationId="updateVin",
    *      tags={"Admin"},
    *      summary="updateVin",
    *      description="updateVin",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="updateVin ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/VinUpdateFormRequest")
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
    
    public function update(VinUpdateFormRequest $request, Vin $vin)
    {
        return $this->showOne(Vin::find($vin)->update($request->validated()));
    }

     /**
    * @OA\Delete(
    *      path="/api/v1/admin/vin/{id}",
    *      operationId="deleteVin",
    *      tags={"Admin"},
    *      summary="deleteVin",
    *      description="deleteVin",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="deleteVin ID",
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
    public function destroy(Vin $vin)
    {
        $vin->delete();
        return $this->showMessage('deleted');
    }
}
