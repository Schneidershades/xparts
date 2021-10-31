<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Vin;
use App\Models\Part;
use App\Models\XpartRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VinPartsFormRequest;

class VinPartsController extends Controller
{
     /**
    * @OA\Post(
    *      path="/api/v1/admin/vin-parts",
    *      operationId="postVinPart",
    *      tags={"Admin"},
    *      summary="postVinPart",
    *      description="postVinPart",
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/VinPartsFormRequest")
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
    public function store(VinPartsFormRequest $request)
    {
        $vin = Vin::where('id', $request['vin_id'])->first();
        $part = Part::where('id', $request['part_id'])->first();
        $xpartRequest = XpartRequest::where('id', $request['xpart_request_id'])->first();
        
        if($vin){
            $vin = $this->contentAndDbIntersection($request->all(), $vin, [], [
                'admin_attention' => $request['make_vin_active']
            ]);
            $vin->save();
        }
        
        if($part){
            $part = $this->contentAndDbIntersection($request->all(), $part, [], [
                'admin_attention' => $request['make_part_active']
            ]);
            $part->save();
        }

        if($request['make_xpart_request_active'] == true){
            $xpartRequest->status = 'active';
            $xpartRequest->save();
        }

        return $this->showOne($xpartRequest);
    }
}
