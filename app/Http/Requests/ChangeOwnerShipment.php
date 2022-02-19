<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Class ChangeOwnerShipment
 * @package App\Http\Requests
 * @property int $user_id - идентификатор нового владельца доставки из таблицы Users
 */
class ChangeOwnerShipment extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->role <= 1;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required|integer|exists:users,id'
        ];
    }

}
