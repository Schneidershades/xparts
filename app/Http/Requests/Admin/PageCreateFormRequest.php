<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Page Create Form Request Fields",
 *      description="Page Create request body data",
 *      type="object",
 *      required={"name"}
 * )
 */

class PageCreateFormRequest extends FormRequest
{
    /**
     * @OA\Property(
     *      title="name",
     *      description="name",
     *      example="name"
     * )
     *
     * @var string
     */
    private $name;

      /**
     * @OA\Property(
     *      title="excerpt",
     *      description="excerpt",
     *      example="small description"
     * )
     *
     * @var string
     */
    private $excerpt;

    /**
     * @OA\Property(
     *      title="content",
     *      description="content",
     *      example="this is a content"
     * )
     *
     * @var string
     */
    private $description;

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
            'name' => 'required|string',
            'excerpt' => 'required|string',
            'description' => 'required|string',
        ];
    }
}
