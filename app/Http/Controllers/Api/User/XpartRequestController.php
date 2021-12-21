<?php

namespace App\Http\Controllers\Api\User;

use App\Models\Vin;
use App\Models\Part;
use App\Models\User;
use App\Models\Media;
use App\Jobs\SendEmail;
use Illuminate\Support\Str;
use App\Models\XpartRequest;
use App\Jobs\PushNotification;
use App\Mail\User\XpartRequestMail;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
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
        $status = null;
        
        $part = Part::where('name', $request['part'])->first();

        if ($part == null) {
            $part = new Part;
            $part->name = strtoupper($request['part']);
            $part->slug = Str::slug($request['part'], '-');
            $part->admin_attention = 1;
            $part->save();
        }

        $vin = Vin::where('vin_number', $request['vin_number'])->first();

        if ($vin == null) {
            $vin = new Vin;
            $vin->vin_number = strtoupper($request['vin_number']);
            $vin->admin_attention = 1;
            $vin->save();
        }
        
        $auth = auth()->user()->id;

        $xpartRequest = new XpartRequest;
        $xpartRequest->part_id = $part->id;
        $xpartRequest->vin_id = $vin->id;
        $xpartRequest->user_id = $auth;
        $xpartRequest->user_description = $request['user_description'] ? $request['user_description'] : null;
        $xpartRequest->status = ($vin->admin_attention == true || $part->admin_attention == true) ? 'awaiting' : 'active';
        $xpartRequest->save();



        if ($request->has('images')) {
            foreach ($request->images as $image) {
                if (gettype($image) != "integer") {
                    $path = $this->uploadImage($image, "xpart_requests");
                    $xpartRequest->images()->create([
                        'file_path' => $path,
                    ]);
                } else {
                    $media = Media::where('id', $image)->first();
                    $media->update([
                        'fileable_id' => $xpartRequest->id,
                        'fileable_type' => $xpartRequest->getMorphClass(),
                    ]);
                }
            }
        }

        // if (auth()->user()->email === 'schneider@fixit45.com' || auth()->user()->email === 'az@fixit45.com'){
        //     return $this->showOne($xpartRequest);
        // }

        if($xpartRequest->status == 'awaiting'){
            $emails = ['az@fixit45.com', 'tolani@fixit45.com', 'henry@fixit45.com',  'schneider@fixit45.com',/**'jt@fixit45.com'**/];

            $admins = User::whereIn('email', $emails)->get(); 

            foreach($admins as $admin){
                SendEmail::dispatch($admin['email'], new XpartRequestMail($xpartRequest, $admin))->onQueue('emails')->delay(5);
            }            
        } 


        $users = User::role('Vendor')->get(); 

        collect($users)->each(function ($user) use ($xpartRequest) {
            if($xpartRequest->status == 'active'){
                
                XpartRequestVendorWatch::create([
                    'xpart_request_id' => $xpartRequest->id,
                    'vendor_id' => $user['id'],
                    'status' => 'active'
                ]);

                SendEmail::dispatch($user['email'], new XpartRequestMail($xpartRequest, $user))->onQueue('emails')->delay(5);

                if($user->has('fcmPushSubscriptions')){
                    PushNotification::dispatch(
                        $xpartRequest, 
                        $xpartRequest->id, 
                        $user, 
                        'New Xpart Request', 
                        'A new xpart request has been created'
                    )->delay(5);
                }
            } 
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
