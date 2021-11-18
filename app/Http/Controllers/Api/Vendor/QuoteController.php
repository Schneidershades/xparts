<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Models\User;
use App\Models\Media;
use App\Models\Quote;
use App\Jobs\SendEmail;
use App\Models\XpartRequest;
use Illuminate\Http\Request;
use App\Models\MarkupPricing;
use App\Events\VendorQuoteSent;
use App\Mail\User\XpartRequestMail;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\User\VendorQuoteSentMail;
use App\Models\XpartRequestVendorWatch;
use App\Http\Requests\Vendor\QuoteCreateFormRequest;

class QuoteController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/v1/vendor/quotes",
     *      operationId="allUsers",
     *      tags={"Vendor"},
     *      summary="allQuotes",
     *      description="allQuotes",
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
        return $this->showAll(auth()->user()->quotes);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/vendor/quotes",
     *      operationId="postQuotes",
     *      tags={"Vendor"},
     *      summary="postQuotes",
     *      description="postQuotes",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/QuoteCreateFormRequest")
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

    public function store(QuoteCreateFormRequest $request)
    {
        $markupPrice = 0;
        $markupDetails = null;

        $vendor = User::where('id', auth()->user()->id)->first();

        $xpartRequest = XpartRequest::where('id', $request['xpart_request_id'])->first();

        $requestingUser = User::where('id', $xpartRequest->user_id)->first();

        $markupDetails = $this->markupService($request['price']);

        if ($markupDetails != null) {
            (float) $calculatedPercentage = (100 + $markupDetails->percentage) / 100;
            (float) $markupPrice = $request['price'] * $calculatedPercentage;
        }

        if ($xpartRequest->status != 'active') {
            return $this->errorResponse('Sorry this quote is expired', 409);
        }

        $model = new Quote;

        $model = $this->requestAndDbIntersection($request, $model, [], [
            'vendor_id' => auth()->user()->id,
            'status' => 'active',
            'markup_pricing_id' => $markupDetails ? $markupDetails->id : null,
            'markup_price' => $markupPrice > 0 ? $markupPrice : $request['price'],
        ]);

        $model->save();

        $quotes_done = XpartRequestVendorWatch::where('vendor_id', $vendor->id)
            ->where('xpart_request_id', $xpartRequest->id)->first();

        $quotes_done->views += 1;
        $quotes_done->number_of_bids += 1;
        $quotes_done->save();

        broadcast(new VendorQuoteSent($vendor, $xpartRequest, $model));

        if ($request->has('images')) {
            foreach ($request['images'] as $image) {
                if (gettype($image) != "integer") {
                    $path = $this->uploadImage($image, "quote_images");
                    $model->images()->create([
                        'file_path' => $path,
                    ]);
                } else {
                    $media = Media::where('id', $image)->first();
                    $media->update([
                        'fileable_id' => $model->id,
                        'fileable_type' => $model->getMorphClass(),
                    ]);
                }
            }
        }

        SendEmail::dispatch($requestingUser->email, new VendorQuoteSentMail($xpartRequest, $requestingUser, $model))->onQueue('emails')->delay(5);

        Log::debug('sent mails');

        return $this->showMessage('Quote has been added to request');
    }

    /**
     * @OA\Get(
     *      path="/api/v1/vendor/quotes/{id}",
     *      operationId="showQuotes",
     *      tags={"Admin"},
     *      summary="showQuotes",
     *      description="showQuotes",
     *      
     *      @OA\Parameter(
     *          name="id",
     *          description="Quote ID",
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
        return $this->showOne(auth()->user()->quotes->where('id', $id)->first());
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/vendor/quotes/{id}",
     *      operationId="deleteQuotes",
     *      tags={"Vendor"},
     *      summary="deleteQuotes",
     *      description="deleteQuotes",
     *      
     *      @OA\Parameter(
     *          name="id",
     *          description="Quote ID",
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


    /**
     * @OA\Get(
     *      path="/api/v1/vendor/others/quotes",
     *      operationId="othersQuotes",
     *      tags={"Vendor"},
     *      summary="othersQuotes",
     *      description="othersQuotes",
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

    public function othersRecentQuote(Request $request)
    {
        $reqId = $request->get('xp_request_id');
        if ($reqId != null) {
            $xpRequestId = $reqId;
        } else {
            $myLastQuote = auth()->user()->quotes()->latest()->first();
            $xpRequestId = $myLastQuote->xpart_request_id;
        }

        if ($xpRequestId) {
            $quotes = Quote::with('vendor:name')
                ->where('xpart_request_id', $xpRequestId)
                ->where('vendor_id', '!=', auth()->user()->id)->get();

            return $this->showAll($quotes);
        }
        return $this->errorResponse("No recent quote", 400);
    }

    public function othersRecentQuoteFromQuoteId($id)
    {
        $myLastQuote = auth()->user()->quotes->where('id', $id)->first();
        if ($myLastQuote) {
            $quotes = Quote::with('vendor:name')
                ->where('xpart_request_id', $myLastQuote->xpart_request_id)->get();

            return $this->showAll($quotes);
        }
        return $this->errorResponse("No recent quote", 400);
    }

    public function markupService($amount)
    {
        $mark =  MarkupPricing::where('min_value', '<=', $amount)
            ->where('max_value', '>=', $amount)
            ->first();
        return ($mark);
    }
}
