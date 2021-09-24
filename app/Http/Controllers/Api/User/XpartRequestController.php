<?php

namespace App\Http\Controllers\Api\User;

use App\Models\Vin;
use App\Models\Part;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\XpartRequest;
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
        $part = Part::where('name', $request->part)->first();

        if($part == null){
            $part = new Part;
            $part->name = $request->part;
            $part->slug = Str::slug($request->part, '-');
            $part->save();
        }

        $vin = Vin::where('vin_number', $request->vin_number)->first();

        if($vin == null){
            $vin = new Vin;
            $vin->vin_number = $request->vin_number;
            $vin->save();
        }

        $auth = auth()->user()->id;

        $xpartRequest = new XpartRequest;
        $xpartRequest->part_id = $part->id;
        $xpartRequest->vin_id = $vin->id;
        $xpartRequest->user_id = $auth;
        $xpartRequest->save();

        $users = User::select('id')->where('role', 'vendor')->get();

        collect($users)->each(function ($user) use ($xpartRequest){
            XpartRequestVendorWatch::insert([
                'xpart_request_id'=> $xpartRequest->id,
                'vendor_id'=> $user['id'],
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
