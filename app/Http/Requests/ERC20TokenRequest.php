<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;


class ERC20TokenRequest extends  \Backpack\CRUD\app\Http\Requests\CrudRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
         switch($this->method())
        {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {
                return [
                     
                    'token_name' => 'required',
                    'token_symbol' => 'required',
                    'token_image' => 'required',
                    'token_contract_address' => 'required',
                    'mode'=>'required',
                    'decimal'=>'required',
                    'eth_address'=>'required',
                    'eth_passphrase'=>'required',
                    'contract_abi'=>'required',
                   
                ];
            }
          
            case 'PUT':
            {                
                return [
                   
                    'token_name' => 'required',
                    'token_image' => 'required',                    
                    'mode'=>'required',
                    'eth_address'=>'required',
                    'eth_passphrase'=>'required',
                    'contract_abi'=>'required',
                    
                   
                ];
            }
            case 'PATCH':        
            default:break;
        }
        
    }

    

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
