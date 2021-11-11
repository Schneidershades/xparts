<?php

namespace App\Http\Requests\Vendor;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Details Create Form Request Fields",
 *      description="Details Create Form request body data",
 *      type="object",
 *      required={"email"}
 * )
 */

class DetailCreateFormRequest extends FormRequest
{

    /**
     * @OA\Property(
     *      title="Part Specalization ID",
     *      description="Part Specalization ID",
     *      example="1"
     * )
     *
     * @var int
     */
    public $part_specialization_id;

    /**
     * @OA\Property(
     *      title="Vehicle Specalization ID",
     *      description="Vehicle Specalization ID",
     *      example="1"
     * )
     *
     * @var int
     */
    public $vehicle_specialization_id;

    /**
     * @OA\Property(
     *      title="Country ID",
     *      description="Country ID",
     *      example="1"
     * )
     *
     * @var int
     */
    public $country_id;

    /**
     * @OA\Property(
     *      title="State ID",
     *      description="State ID",
     *      example="1"
     * )
     *
     * @var int
     */
    public $state_id;


    /**
     * @OA\Property(
     *      title="City ID",
     *      description="City ID",
     *      example="1"
     * )
     *
     * @var int
     */
    public $city_id;

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
     *      title="Business Name",
     *      description="Business Name",
     *      example="Okonjo and sons limited"
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
     *      example="Business"
     * )
     *
     * @var string
     */
    public $type;

    /**
     * @OA\Property(
     *      title="Bank Account Name",
     *      description="Bank Account Name",
     *      example="Michael Ogbuma"
     * )
     *
     * @var string
     */
    public $bank_account_name;

    /**
     * @OA\Property(
     *      title="Bank Account Number",
     *      description="Bank Account Number",
     *      example="02933311112"
     * )
     *
     * @var string
     */
    public $bank_account_number;


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
            'bank_id' => 'required|int|exists:banks,id',
            'bank_account_name' => 'required|string',
            'bank_account_number' => 'required|string|max:12',
            'part_specialization_id' => 'sometimes|int|exists:part_specializations,id',
            'vehicle_specialization_id' => 'sometimes|int|exists:vehicle_specializations,id',
            'name' => 'required|string',
            'address' => 'required|string',
            'type' => 'required|string|max:255|in:Business',
            'state_id' => 'required|integer',
            'city_id' => 'required|integer',
            'country_id' => 'required|integer',
        ];
    }
}
