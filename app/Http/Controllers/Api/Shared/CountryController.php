<?php

namespace App\Http\Controllers\Api\Shared;

use App\Models\Country;
use App\Http\Controllers\Controller;

class CountryController extends Controller
{
    /**
    * @OA\Get(
    *      path="/api/v1/shared/countries",
    *      operationId="allCountries",
    *      tags={"location"},
    *      summary="Get all countries",
    *      description="Get all countries",
    *      @OA\Response(
    *          response=200,
    *          description="Successful operation",
    *          @OA\MediaType(
    *             mediaType="application/json",
    *         ),
    *       ),
    * )
    */

    public function index()
    {
        return $this->showAll(Country::all());
    }

    /**
    * @OA\Get(
    *      path="/api/v1/shared/countries/{id}",
    *      operationId="countryID",
    *      tags={"location"},
    *      summary="Get details of country by id with attached states",
    *      description="Get country with states in a country",
    *      @OA\Parameter(
    *          name="id",
    *          description="Country ID",
    *          required=true,
    *          in="path",
    *          @OA\Schema(
    *              type="integer"
    *          )
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="Successful operation",
    *          @OA\MediaType(
    *             mediaType="application/json",
    *         ),
    *       ),
    * )
    */

    public function show($id)
    {
        return $this->showOne(Country::find($id));
    }
}
