<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Vin;
use App\Models\Part;
use App\Models\User;
use App\Jobs\SendEmail;
use App\Models\XpartRequest;
use App\Mail\User\XpartRequestMail;
use App\Http\Controllers\Controller;
use App\Models\XpartRequestVendorWatch;
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
            $vin->update([
                'make' => $request['make'],
                'model' => $request['model'],
                'model_year' => $request['year'],
                'admin_attention' => $request['make_vin_active']
            ]);
        }

// make: "toyota"
// make_part_active: false
// make_vin_active: false
// make_xpart_request_active: false
// model: "toyota"
// name: "CARBURETTORS"
// part_id: 97
// vin_id: 15
// xpart_request_id: 375
// year: "2004"

// make: "toyota"
// make_part_active: true
// make_vin_active: true
// make_xpart_request_active: true
// model: "toyota"
// name: "CARBURETTORS"
// part_id: 97
// vin_id: 15
// xpart_request_id: 375
// year: "2004"
        
        if($part){
            $part->update([
                'name' => $request['name'],
                'admin_attention' => $request['make_part_active']
            ]);
        }

        if($request['make_xpart_request_active'] == true){
            $xpartRequest->status = 'active';
            $xpartRequest->save();

            $users = User::select('email', 'name', 'id')->where('role', 'vendor')->where('id', '!=', auth()->user()->id)->get();

            collect($users)->each(function ($user) use ($xpartRequest) {
                if($xpartRequest->status == 'active'){   
                    XpartRequestVendorWatch::create([
                        'xpart_request_id' => $xpartRequest->id,
                        'vendor_id' => $user['id'],
                        'status' => 'active'
                    ]);
                    SendEmail::dispatch($user['email'], new XpartRequestMail($xpartRequest, $user))->onQueue('emails')->delay(5);
                } 
            });
        }

        return $this->showOne($xpartRequest);
    }
}
