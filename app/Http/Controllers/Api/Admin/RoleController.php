<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleCreateFormRequest;
use App\Http\Requests\Admin\RoleUpdateFormRequest;

class RoleController extends Controller
{
    /**
    * @OA\Get(
    *      path="/api/v1/admin/roles",
    *      operationId="allRoles",
    *      tags={"Admin"},
    *      summary="Get all roles",
    *      description="Get all roles",
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
        return $this->showAll(Role::all());
    }

    /**
    * @OA\Post(
    *      path="/api/v1/admin/roles",
    *      operationId="postRole",
    *      tags={"Admin"},
    *      summary="Post roles",
    *      description="Post roles",
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/RoleCreateFormRequest")
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
    public function store(RoleCreateFormRequest $request)
    {
        return $this->showOne(Role::create($request->validated()));
    }

    /**
    * @OA\Get(
    *      path="/api/v1/admin/roles/{id}",
    *      operationId="showRole",
    *      tags={"Admin"},
    *      summary="Show role",
    *      description="Show role",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="Role ID",
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
    public function show(Role $role)
    {
        return $this->showOne(Role::findOrFail($role->id));
    }

    /**
    * @OA\Put(
    *      path="/api/v1/admin/roles/{id}",
    *      operationId="RoleUpdate",
    *      tags={"Admin"},
    *      summary="Update role",
    *      description="Update role",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="role ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/RoleUpdateFormRequest")
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
    
    public function update(RoleUpdateFormRequest $request, Role $role)
    {
        ($role->update($request->validated()));
        return $this->showOne($role);
    }

     /**
    * @OA\Delete(
    *      path="/api/v1/admin/roles/{id}",
    *      operationId="deleteRole",
    *      tags={"Admin"},
    *      summary="Delete role",
    *      description="Delete role",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="Role ID",
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
    public function destroy(Role $role)
    {
        $role->delete();
        return $this->showMessage('deleted');
    }
}
