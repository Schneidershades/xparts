<?php

namespace App\Http\Controllers\Api\ExportImport;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ModelImportExportController extends Controller
{
     /**
    * @OA\Get(
    *      path="/api/v1/export/excel/model?search={name}&per_page={per_page}",
    *      operationId="searchParts",
    *      tags={"Shared"},
    *      summary="searchParts",
    *      description="searchParts",
    *      @OA\Parameter(
    *          name="name",
    *          description="Search Items",
    *          required=false,
    *          in="path",
    *          @OA\Schema(
    *              type="string"
    *          )
    *      ),
    *      @OA\Parameter(
    *          name="per_page",
    *          description="Number per page",
    *          required=true,
    *          in="path",
    *          @OA\Schema(
    *              type="string"
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
    public function export(Request $request)
    {
        if($request->query('export') == null){
            return $this->errorResponse('no export model was selected from frontend', 409);
        }

        $fileName = sprintf('%s_export_%s.xlsx', strtolower($request->query('model')), now()->format('Ymd_Hi'));
        $namespace =  "\App\Exports\\" . $request->query('export');

        return (new $namespace)->download($fileName);
    }
}
