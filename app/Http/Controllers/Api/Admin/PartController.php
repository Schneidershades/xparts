<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Part;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PartCreateFormRequest;
use App\Http\Requests\Admin\PartUpdateFormRequest;

class PartController extends Controller
{
    /**
    * @OA\Get(
    *      path="/api/v1/admin/parts",
    *      operationId="allParts",
    *      tags={"Admin"},
    *      summary="getParts",
    *      description="getParts",
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
        return $this->showAll(Part::all());
    }

    /**
    * @OA\Post(
    *      path="/api/v1/admin/part",
    *      operationId="postPart",
    *      tags={"Admin"},
    *      summary="postPart",
    *      description="postPart",
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/PartCreateFormRequest")
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
    public function store(PartCreateFormRequest $request)
    {
        return $this->showOne(Part::create($request->validated()));
    }

    /**
    * @OA\Get(
    *      path="/api/v1/admin/part/{id}",
    *      operationId="showPart",
    *      tags={"Admin"},
    *      summary="showPart",
    *      description="showPart",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="showPart ID",
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
        return $this->showOne(Part::findOrFail($id));
    }

    /**
    * @OA\Put(
    *      path="/api/v1/admin/part/{id}",
    *      operationId="updatePart",
    *      tags={"Admin"},
    *      summary="updatePart",
    *      description="updatePart",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="updatePart ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/PartUpdateFormRequest")
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
    
    public function update(PartUpdateFormRequest $request, Part $part)
    {
        return $this->showOne(Part::find($part)->update($request->validated()));
    }

     /**
    * @OA\Delete(
    *      path="/api/v1/admin/part/{id}",
    *      operationId="deletePart",
    *      tags={"Admin"},
    *      summary="deletePart",
    *      description="deletePart",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="deletePart ID",
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
    public function destroy(Part $part)
    {
        $part->delete();
        return $this->showMessage('deleted');
    }
}
