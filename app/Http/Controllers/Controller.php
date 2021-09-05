<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Schema;
use App\Traits\Api\ApiResponder;

use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, ApiResponder;

    // add extra function to access receiving requests
    
    public function getColumns($table)
    {       
        $columns = Schema::getColumnListing($table);
        return $columns;
    }

    public function requestAndDbIntersection($request, $model, array $excludeFieldsForLogic = [], array $includeFields = [])
    {        
        $excludeColumns = array_diff($request->all(), $excludeFieldsForLogic);
        
        $allReadyColumns = array_merge($excludeColumns, $includeFields);

        $requestColumns = array_keys($allReadyColumns);

        $tableColumns = $this->getColumns($model->getTable());

        $fields = array_intersect($requestColumns, $tableColumns);

        foreach($fields as $field){
            $model->{$field} = $allReadyColumns[$field];
        }

        return $model;
    }

    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="Xpart App OpenApi API Documentation",
     *      description="Xpart App Using L5 Swagger OpenApi description",
     *      @OA\Contact(
     *          email="schneidershades@gmail.com"
     *      ),
     *      @OA\License(
     *          name="Apache 2.0",
     *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *      )
     * )
     *
     *
     * @OA\Tag(
     *     name="Xpart Application",
     *     description="API Endpoints of Projects"
     * )
     *
     *  @OA\SecurityScheme(
     *     securityScheme="bearerAuth",
     *     type="http",
     *     scheme="bearer"
     * )
     *
     */
}
