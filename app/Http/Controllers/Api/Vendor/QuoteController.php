<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Events\VendorQuoteSent;
use App\Models\Quote;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\QuoteCreateFormRequest;
use App\Models\User;
use App\Models\XpartRequest;

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
        $vendor = User::where('id', auth()->user()->id)->first();

        $model = new Quote;
        $model = $this->requestAndDbIntersection($request, $model, [], [
            'vendor_id' => auth()->user()->id
        ]);
        $model->save();

        $xpartRequest = XpartRequest::where('id', $request['xpart_request_id'])->first();
        
        $quote = $model;

        dd($vendor, $xpartRequest, $quote);

        // broadcast(new VendorQuoteSent($vendor, $xpartRequest, $quote));

        if ($request->has('images')) {
            foreach ($request['images'] as $image) {
                $path = $this->uploadImage($image, "quote_images");
                $model->images()->create([
                    'file_path' => $path,
                ]);
            }
        }

        return $this->showAll(auth()->user()->quotes);
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

    public function othersRecentQuote()
    {
        $myLastQuote = auth()->user()->quotes()->latest()->first();
        if ($myLastQuote) {
            $quotes = Quote::with('vendor:name')
                ->where('xpart_request_id', $myLastQuote->xpart_request_id)
                ->where('id', '!=', $myLastQuote->id)->get();

            return $this->showAll($quotes);
        }
        return $this->errorResponse("No recent quote", 400);
    }
}
