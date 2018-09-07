<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Validator;
class CurrencyRequest extends \Backpack\CRUD\app\Http\Requests\CrudRequest
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
                
               /*  return [
                     'name' => 'required|unique:currencies',
                   
                ];*/
                return [
                     'image' => 'required',
                   
                ];
            }
          
            case 'PUT':
            {
                

                // Validator::extend('file_extension', function($attribute, $value, $parameters, $validator) 
                // {
                //     if(!$value instanceof UploadedFile) {
                //     return false;
                // }
                //     $extension = $value->getClientOriginalExtension();
                //     return $extension != '' && in_array($extension, $parameters);
                // },trans('forms.file_extension_error'));

                // Validator::extend('checkfile', function ($attribute, $value, $parameters, $validator) 
                // {
                //     if (!$value->isValid())
                //     { 
                //         return false;
                //     }
                //         return true;
                // });

                return [
                    'image' => 'required',
                   
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
