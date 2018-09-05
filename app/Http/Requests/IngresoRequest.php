<?php

namespace sisVentas\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IngresoRequest extends FormRequest
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
            'idproveedor' =>'required',
            'tipocomprovante' =>'required|max:20',
            'seriecomprovante' =>'max:7',
            'numerocomprovante' => 'required|max:10',
            'idarticulo' =>'required',
            'cantidad' =>'required',
            'preciocompra' => 'required',
            'precioventa'=>'required',

        ];
    }
}
