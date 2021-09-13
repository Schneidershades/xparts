<?php

namespace App\Http\Controllers\Api\Shared;

use App\Models\Bank;
use App\Http\Controllers\Controller;

class BankController extends Controller
{
    /**
    * @OA\Get(
    *      path="/api/v1/shared/banks",
    *      operationId="allBanks",
    *      tags={"Shared"},
    *      summary="allBanks",
    *      description="allBanks",
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
        return $this->showAll(Bank::all());
    }
}
