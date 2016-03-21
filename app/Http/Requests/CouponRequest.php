<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CouponRequest extends Request
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
            //
        ];
    }

    public function prepare(array $input)
    {
        if (empty($this->get('code'))) {
            $input['code'] = str_random();
        }
        if (!empty($this->get('ends_at'))) {
            $input['ends_at'] = date('Y-m-d H:i:s', strtotime($this->get('ends_at')));
        }
        return $input;
    }
}
