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

class DetailCreateFormRequest extends FormRequest
{

    /**
     * @OA\Property(
     *      title="Part ID",
     *      description="Part ID",
     *      example="1"
     * )
     *
     * @var int
     */
    public $part_id;

    /**
     * @OA\Property(
     *      title="Bank ID",
     *      description="Bank ID",
     *      example="1"
     * )
     *
     * @var int
     */
    public $bank_id;

    /**
     * @OA\Property(
     *      title="Category One ID",
     *      description="Category One ID",
     *      example="1"
     * )
     *
     * @var int
     */
    public $category_one_id;



    /**
     * @OA\Property(
     *      title="Business Name",
     *      description="Business Name",
     *      example="quote"
     * )
     *
     * @var string
     */
    public $name;

    /**
     * @OA\Property(
     *      title="Business Address",
     *      description="Business Address",
     *      example="quote"
     * )
     *
     * @var string
     */
    public $address;

    /**
     * @OA\Property(
     *      title="Business Type",
     *      description="Business Type",
     *      example="quote"
     * )
     *
     * @var string
     */
    public $type;


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
            'bank_id' => 'required|int|exists:banks,id',
            'category_one_id' => 'sometimes|int|exists:category_ones,id',
            'part_id' => 'sometimes|int|exists:parts,id',
            'name' => 'required|string',
            'address' => 'required|string',
            'type' => 'required|string|max:255|in:Business',
        ];
    }
}
