<?php

namespace App\Http\Requests\Vendor;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Quote Create Form Request Fields",
 *      description="Quote Create Form request body data",
 *      type="object",
 *      required={"email"}
 * )
 */

class QuoteCreateFormRequest extends FormRequest
{
    /**
     * @OA\Property(
     *      title="Xpart Request Id",
     *      description="Xpart Request Id",
     *      example="1"
     * )
     *
     * @var string
     */
    public $xpart_request_id;

    /**
     * @OA\Property(
     *      title="Part Grade Id",
     *      description="Part Grade Id",
     *      example="1"
     * )
     *
     * @var string
     */
    public $part_grade_id;

    /**
     * @OA\Property(
     *      title="User State",
     *      description="state of the user",
     *      example="1"
     * )
     *
     * @var string
     */
    public $state_id;

    /**
     * @OA\Property(
     *      title="User City",
     *      description="City of the user",
     *      example="1"
     * )
     *
     * @var string
     */
    public $city_id;



    /**
     * @OA\Property(
     *      title="Quantity",
     *      description="Quantity of the part",
     *      example="1"
     * )
     *
     * @var string
     */
    public $quantity;

    /**
     * @OA\Property(
     *      title="Part Number",
     *      description="Number of the Part",
     *      example="XXEREIR#11239"
     * )
     *
     * @var string
     */
    public $part_number;

    /**
     * @OA\Property(
     *      title="Part Warranty",
     *      description="Warranty of the Part",
     *      example="1"
     * )
     *
     * @var int
     */
    public $part_warranty;

    /**
     * @OA\Property(
     *      title="Price",
     *      description="Price of part",
     *      example="1"
     * )
     *
     * @var int
     */
    public $price;

    /**
     * @OA\Property(
     *      title="Description",
     *      description="Description of the part",
     *      example="It is good"
     * )
     *
     * @var string
     */
    public $description;
    /**
     * @OA\Property(
     *      title="Brand",
     *      description="Brand of the part",
     *      example="LG"
     * )
     *
     * @var string
     */
    public $brand;

    /**
     *       @OA\Property(property="images", type="object", type="array",
     *            @OA\Items(
     *                @OA\Property(property="images", type="string", example="https://"),
     *            ),
     *        ),
     *    ),
     */
    public $images;

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
            'xpart_request_id' => 'required|int|exists:xpart_requests,id',
            'part_grade_id' => 'required|int|exists:part_grades,id',
            'state_id' => 'required|int|exists:states,id',
            'city_id' => 'required|int|exists:cities,id',
            'quantity' => 'required|int|gt:0',
            'measurement' => 'required|string',
            'price' => 'required|numeric|gt:0',
            'part_number' => 'nullable',
            'part_warranty' => 'nullable',
            'description' => 'nullable',
            'brand' => 'nullable',
            'images' => 'nullable|array',
            'images.*' => 'nullable|max:2048',  
        ];
    }
}
