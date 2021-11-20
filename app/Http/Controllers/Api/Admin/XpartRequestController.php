<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\XpartRequest;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Requests\Admin\XpartRequestStoreFormRequest;
use App\Http\Requests\Admin\AdminXpartRequestUpdateFormRequest;

class XpartRequestController extends Controller
{
     /**
    * @OA\Get(
    *      path="/api/v1/admin/xpart-requests",
    *      operationId="allXpartRequest",
    *      tags={"Admin"},
    *      summary="allXpartRequest",
    *      description="allXpartRequest",
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
            return $this->showAll(XpartRequest::latest()->get());
        }

        $item =  XpartRequest::query()
                    ->selectRaw('xpart_requests.*')
                    ->selectRaw('users.name AS user_name')
                    ->selectRaw('parts.name AS part_name')
                    ->selectRaw('vins.vin_number AS vin_number')
                    ->leftJoin('users', 'users.id', '=', 'xpart_requests.user_id')
                    ->leftJoin('parts', 'parts.id', '=', 'xpart_requests.part_id')
                    ->leftJoin('addresses', 'addresses.id', '=', 'xpart_requests.address_id')
                    ->leftJoin('vins', 'vins.id', '=', 'xpart_requests.vin_id')
                    ->when($search_query, function (Builder $builder, $search_query) {
                        $builder->where('vin_number', 'LIKE', "%{$search_query}%")
                        ->orWhere('users.name', 'LIKE', "%{$search_query}%")
                        ->orWhere('parts.name', 'LIKE', "%{$search_query}%")
                        ->orWhere('xpart_requests.id', 'LIKE', "%{$search_query}%")
                        ;
                    })->get();

        return $this->showAll($item);
    }


    /**
    * @OA\Post(
    *      path="/api/v1/admin/xpart-requests",
    *      operationId="postPart",
    *      tags={"Admin"},
    *      summary="postPart",
    *      description="postPart",
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/XpartRequestStoreFormRequest")
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
    public function store(XpartRequestStoreFormRequest $request)
    {
        return $this->showOne(XpartRequest::create($request->validated()));
    }

    /**
    * @OA\Get(
    *      path="/api/v1/admin/xpart-requests/{id}",
    *      operationId="showXpartRequest",
    *      tags={"Admin"},
    *      summary="Show XpartRequest",
    *      description="Show XpartRequest",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="XpartRequest ID",
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
        return $this->showOne(XpartRequest::findOrFail($id));
    }

     /**
    * @OA\Put(
    *      path="/api/v1/admin/xpart-requests/{id}",
    *      operationId="updateXpartRequest",
    *      tags={"Admin"},
    *      summary="updateXpartRequest",
    *      description="updateXpartRequest",
    *      
     *      @OA\Parameter(
     *          name="id",
     *          description="updateXpartRequest ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/AdminXpartRequestUpdateFormRequest")
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
    
    public function update(AdminXpartRequestUpdateFormRequest $request, $id)
    {
        $xpartRequest = XpartRequest::where('id', $id)->first();
        
        $xpartRequest->admin_description = $request['admin_description'];

        $xpartRequest->save();
        
        return $this->showOne($xpartRequest);
    }

}
