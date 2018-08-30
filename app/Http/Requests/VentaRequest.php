<?php

namespace sisVentas\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VentaRequest extends FormRequest
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
            'idCliente' =>'required',
            'tipoComprovante' =>'required|max:20',
            'serieComprovante' =>'max:7',
            'numeroComprovante' => 'required|max:10',
            'idArticulo' =>'required',
            'cantidad' =>'required',
            'precioVenta' => 'required',
            'descuento'=>'required',
            'totalVenta'=>'required',
        ];
    }
}
