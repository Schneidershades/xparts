<?php

namespace App\Http\Requests\Vendor;

use Illuminate\Foundation\Http\FormRequest;

/**
/**
 * @OA\Schema(
 *      title="Quote Create Form Request Fields",
 *      descriptioQuote Create Form request body data",
 *      type="object",
 *      required={"email"}
 * )
 */

class QuoteCreateFormRequest extends FormRequest
{
    /**
     * @OA\Property(
     *      title="Xpart Request ID",
     *      description="Xpart Request ID",
     *      example="1"
     * )
     *
     * @var int
     */
    public $xpart_request_id;

    /**
     * @OA\Property(
     *      title="Part Grade ID",
     *      description="Part Grade ID",
     *      example="1"
     * )
     *
     * @var int
     */
    public $part_grade_id;


    /**
     * @OA\Property(
     *      title="Part Category ID",
     *      description="Part Category ID",
     *      example="1"
     * )
     *
     * @var int
     */
    public $part_category_id;


    /**
     * @OA\Property(
     *      title="Part SubcPart Category ID",
     *      description="Part SubcPart Category ID",
     *      example="1"
     * )
     *
     * @var int
     */
    public $part_subcategory_id;


    /**
     * @OA\Property(
     *      title="Part Condition ID",
     *      description="Part Condition ID",
     *      example="1"
     * )
     *
     * @var int
     */
    public $part_condition_id;

    /**
     * @OA\Property(
     *      title="Brand of the part",
     *      description="Brand of the parts",
     *      example="motorola"
     * )
     *
     * @var string
     */
    public $brand;

    /**
     * @OA\Property(
     *      title="Quantity",
     *      description="Quantity",
     *      example="234"
     * )
     *
     * @var int
     */
    public $quantity;

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
     *      title="Part Warranty",
     *      description="Part Warranty",
     *      example="3"
     * )
     *
     * @var int
     */
    public $part_warranty;

    /**
     * @OA\Property(
     *      title="Part Price",
     *      description="Part Price",
     *      example="3"
     * )
     *
     * @var int
     */
    public $price;

    /**
     * @OA\Property(
     *      title="Description",
     *      description="Description",
     *      example="This is ......................."
     * )
     *
     * @var string
     */
    public $description;
    

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
            'xpart_request_id' => 'required|int',
            'part_grade_id' => 'required|int',
            'part_category_id' => 'required|int',
            'part_subcategory_id' => 'required|int',
            'part_condition_id' => 'required|int',
            'brand' => 'required|string',
            'quantity' => 'required|int',
            'part_number' => 'required|string',
            'part_warranty' => 'required|int',
            'price' => 'required|int',
            'description' => 'required|string',
        ];
    }
}