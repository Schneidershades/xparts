<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserXpartRequestController extends Controller
{
    /**
    * @OA\Get(
    *      path="/api/v1/vendor/assigned-xpart-requests",
    *      operationId="allAssignedXpartRequest",
    *      tags={"Vendor"},
    *      summary="allAssignedXpartRequest",
    *      description="allAssignedXpartRequest",
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
        return $this->showAll(auth()->user()->xpartRequestVendorWatch);
    }

    /**
    * @OA\Delete(
    *      path="/api/v1/vendor/assigned-xpart-requests/{id}",
    *      operationId="deleteAssignedXpartRequest",
    *      tags={"Vendor"},
    *      summary="deleteAssignedXpartRequest",
    *      description="deleteAssignedXpartRequest",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="Assigned ID",
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
    public function destroy(Request $request, $id)
    {
        auth()->user()->quotes->where('id', $id)->first()->delete();
        return $this->showMessage('Model deleted');
    }
}
