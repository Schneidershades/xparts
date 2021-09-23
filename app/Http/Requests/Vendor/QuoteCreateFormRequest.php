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
    *       @OA\Property(property="quotes", type="object", type="array",
    *            @OA\Items(
    *                @OA\Property(property="xpart_request_id", type="int", example="1"),
    *                @OA\Property(property="part_grade_id", type="int", example="1"),
    *                @OA\Property(property="state_id", type="int", example="1"),
    *                @OA\Property(property="city_id", type="int", example="1"),
    *                @OA\Property(property="brand", type="string", example="Motorola"),
    *                @OA\Property(property="quantity", type="int", example="1"),
    *                @OA\Property(property="part_number", type="string", example="No5JesusStreet"),
    *                @OA\Property(property="part_warranty", type="string", example="2"),
    *                @OA\Property(property="price", type="int", example="500000"),
    *                @OA\Property(property="description", type="string", example="description"),
    *            ),
    *        ),
    *    ),
    */
    public $quotes;

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
            'quotes' => 'required|array', 
            'quotes.*.xpart_request_id' => 'required|int|exists:xpart_requests,id',
            'quotes.*.part_grade_id' => 'required|int|exists:part_grades,id',
            'quotes.*.state_id' => 'required|int|exists:states,id',
            'quotes.*.city_id' => 'required|int|exists:cities,id',
            'quotes.*.brand' => 'string',
            'quotes.*.quantity' => 'required|int',
            'quotes.*.part_number' => 'string',
            'quotes.*.part_warranty' => 'int',
            'quotes.*.price' => 'required|int',
            'quotes.*.description' => 'string',
        ];
    }
}