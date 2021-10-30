<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Vin Parts  Form Request Fields",
 *      description="Vin Parts  Form request body data",
 *      type="object",
 *      required={"email"}
 * )
 */

class VinPartsFormRequest extends FormRequest
{
    /**
     * @OA\Property(
     *      title="vinid",
     *      description="vin id",
     *      example="1"
     * )
     *
     * @var int
     */
    private $vin_id;

    /**
     * @OA\Property(
     *      title="part id",
     *      description="part id",
     *      example="1"
     * )
     *
     * @var int
     */
    private $part_id;

    /**
     * @OA\Property(
     *      title="xpart request id",
     *      description="xpart request id",
     *      example="1"
     * )
     *
     * @var int
     */
    private $xpart_request_id;


    /**
     * @OA\Property(
     *      title="make",
     *      description="vin make",
     *      example="toyota"
     * )
     *
     * @var string
     */
    private $make;



    /**
     * @OA\Property(
     *      title="model",
     *      description="vin model",
     *      example="toyota"
     * )
     *
     * @var string
     */
    private $model;


    /**
     * @OA\Property(
     *      title="model_year",
     *      description="vin model_year",
     *      example="toyota"
     * )
     *
     * @var string
     */
    private $model_year;

    /**
     * @OA\Property(
     *      title="make_part_active",
     *      description="make_part_active",
     *      example="true"
     * )
     *
     * @var boolean
     */
    private $make_part_active;


    /**
     * @OA\Property(
     *      title="make_vin_active",
     *      description="make_vin_active",
     *      example="true"
     * )
     *
     * @var boolean
     */
    private $make_vin_active;

    /**
     * @OA\Property(
     *      title="make_xpart_request_active",
     *      description="make_xpart_request_active",
     *      example="true"
     * )
     *
     * @var boolean
     */
    private $make_xpart_request_active;


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'vin_id' => 'required|integer|exists:vins,id',
            'xpart_request_id' => 'required|integer|exists:xpart_requests,id',
            'part_id' => 'required|integer|exists:parts,id',
            'make' => 'nullable',
            'model' => 'nullable',
            'model_year' => 'nullable',
            'make_part_active' => 'required|boolean',
            'make_vin_active' => 'required|boolean',
            'make_xpart_request_active' => 'required|boolean',
        ];
    }
}