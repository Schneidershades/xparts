<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\PartGrade;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PartGradeController extends Controller
{
     /**
    * @OA\Get(
    *      path="/api/v1/admin/part-grades",
    *      operationId="allPartGrades",
    *      tags={"Admin"},
    *      summary="allPartGrades",
    *      description="allPartGrades",
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
        $this->showAll(PartGrade::all());
    }
}
