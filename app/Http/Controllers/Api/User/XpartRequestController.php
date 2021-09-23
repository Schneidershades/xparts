<?php

namespace App\Http\Controllers\Api\User;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\XpartRequestVendorWatch;
use App\Http\Requests\User\XpartCreateFormRequest;

class XpartRequestController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/v1/xpart-requests",
     *      operationId="allXpartRequest",
     *      tags={"User"},
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
        return $this->showAll(auth()->user()->xpartRequests);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/xpart-requests",
     *      operationId="postXpartRequests",
     *      tags={"User"},
     *      summary="postXpartRequests",
     *      description="postXpartRequests",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/XpartCreateFormRequest")
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
    public function store(XpartCreateFormRequest $request)
    {
        $users = User::select('id')->where('role', 'vendor')->get();

        $xpartRequest = auth()->user()->xpartRequests()->create($request->validated());
        if ($request->has('images')) {
            foreach ($request->images as $image) {
                $path = $this->uploadImage($image, "xpart_requests");
                $xpartRequest->images()->create([
                    'file_path' => $path,
                ]);
            }
        }

        collect($users)->each(function ($user) use ($xpartRequest) {
            XpartRequestVendorWatch::insert([
                'xpart_request_id' => $xpartRequest->id,
                'vendor_id' => $user['id'],
            ]);
        });

        return $this->showOne($xpartRequest);
    }

    /**
     * @OA\Get(
     *      path="/api/v1/xpart-requests/{id}",
     *      operationId="showXpartRequests",
     *      tags={"User"},
     *      summary="showXpartRequests",
     *      description="showXpartRequests",
     *      
     *      @OA\Parameter(
     *          name="id",
     *          description="Xpart Request ID",
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
        return $this->showOne(auth()->user()->xpartRequests->where('id', $id)->load('vendorQuotes')->first());
    }
}
