<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class DeliveredShipmentsRequest
 * @package App\Http\Requests
 *
 * @property string $from
 * @property string $app
 */
class DeliveredShipmentsRequest extends FormRequest
{
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
            'from' => 'string|max:255',
            'app' => ['required', Rule::in(['1c'])],
        ];
    }
}
