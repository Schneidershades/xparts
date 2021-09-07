<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Xpart Request Create Form Request Fields",
 *      description="Xpart Request Create Form request body data",
 *      type="object",
 *      required={"email"}
 * )
 */

class XpartCreateFormRequest extends FormRequest
{
    /**
     * @OA\Property(
     *      title="Xpart Part ID",
     *      description="Xpart Part ID",
     *      example="1"
     * )
     *
     * @var int
     */
    public $part_id;

    /**
     * @OA\Property(
     *      title="Category Three Part ID",
     *      description="Category Three Part ID",
     *      example="1"
     * )
     *
     * @var int
     */
    public $category_three_part_id;


   
    /**
     * @OA\Property(
     *      title="Part Number",
     *      description="Part number",
     *      example="NCEI3043NEWIWW"
     * )
     *
     * @var string
     */
    public $part_number;

    /**
     * @OA\Property(
     *      title="Car VIN",
     *      description="Car VIN",
     *      example="CNCIEI30330DN3993"
     * )
     *
     * @var string
     */
    public $vin;

    /**
     * @OA\Property(
     *      title="Car Make",
     *      description="Car Make",
     *      example="3"
     * )
     *
     * @var int
     */
    public $make;

    /**
     * @OA\Property(
     *      title="Car Model",
     *      description="Car Model",
     *      example="3"
     * )
     *
     * @var int
     */
    public $model;

    /**
     * @OA\Property(
     *      title="Car Year",
     *      description="Car Year",
     *      example="3"
     * )
     *
     * @var int
     */
    public $year;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'part_id' => 'required|int|exists:parts,id',
            'category_three_part_id' => 'int|exists:category_three_parts,id',
            'vin' => 'required|string',
            'make' => 'required|string',
            'model' => 'required|string',
            'year' => 'required|string',        
        ];
    }
}
