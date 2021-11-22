<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Requests\Admin\UserUpdateFormRequest;

class VendorController extends Controller
{
    /**
    * @OA\Get(
    *      path="/api/v1/admin/vendors",
    *      operationId="allVendors",
    *      tags={"Admin"},
    *      summary="Get all vendors",
    *      description="Get all vendors",
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
        $search_query = request()->get('search') ? request()->get('search') : null;

        if(!$search_query){
            return $this->showAll(User::where('role', 'vendor')->latest()->get());
        }

        $item = User::query()
                ->selectRaw('users.*')
                ->where('users.role', 'vendor')
                ->when($search_query, function (Builder $builder, $search_query) {
                    $builder->where('users.name', 'LIKE', "%{$search_query}%")
                    ->orWhere('users.name', 'LIKE', "%{$search_query}%")
                    ->orWhere('users.phone', 'LIKE', "%{$search_query}%")
                    ->orWhere('users.email', 'LIKE', "%{$search_query}%");
                })->latest()->get();

        return $this->showAll($item);
    }

    /**
    * @OA\Post(
    *      path="/api/v1/admin/vendors",
    *      operationId="postVendors",
    *      tags={"Admin"},
    *      summary="Post vendors",
    *      description="Post vendors",
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/UserCreateFormRequest")
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
    public function store(Request $request)
    {
        return $this->showOne(auth()->user()->vendors->create($request->validated()));
    }

    /**
    * @OA\Get(
    *      path="/api/v1/admin/vendors/{id}",
    *      operationId="showVendor",
    *      tags={"Admin"},
    *      summary="Show vendor",
    *      description="Show vendor",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="Vendor ID",
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
        return $this->showOne(User::findOrFail($id));
    }

    /**
    * @OA\Put(
    *      path="/api/v1/admin/vendors/{id}",
    *      operationId="VendorUpdate",
    *      tags={"Admin"},
    *      summary="Update Vendor",
    *      description="Update Vendor",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="Vendor ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/UserCreateFormRequest")
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
    
    public function update(UserUpdateFormRequest $request, User $user)
    {
        ($user->update($request->validated()));
        return $this->showOne($user);
    }

     /**
    * @OA\Delete(
    *      path="/api/v1/admin/vendors/{id}",
    *      operationId="deleteVendor",
    *      tags={"Admin"},
    *      summary="Delete Vendor",
    *      description="Delete Vendor",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="Vendor ID",
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
    public function destroy(User $user)
    {
        $user->delete();
        return $this->showMessage('deleted');
    }
}
