<?php

namespace sisVentas\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Input;

class UserRequest extends FormRequest
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

        if (Input::has('id')){
            $idc=Input::get('id');
            return [
               
                'name' => 'required|string|max:200',
                'email' => 'required|string|email|max:200|unique:users,email,'.$idc.',id',
                'password' => 'required|string|min:6|confirmed',
      
            ];
        }else{

            return [
                'name' => 'required|string|max:200',
                'email' => 'required|string|email|max:200|unique:users',
                'password' => 'required|string|min:6|confirmed',
      
            ];
        }
       
    }
}
