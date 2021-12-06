<?php

namespace App\Http\Controllers\Api\ExportImport;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ModelImportExportController extends Controller
{
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
