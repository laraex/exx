<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PageRequest extends \Backpack\CRUD\app\Http\Requests\CrudRequest
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
        return [
            'title' => 'required',
            'navlabel' => 'required',
            'content' => 'required',
            'seotitle' => 'required',
            'seokeyword' => 'required',
            'active' => 'required',
        ];
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
            'title.required' => 'Page title is required',
            //'pagetitle.unique' => 'Page title is already exists',   
            'navlabel.required' => 'Navigation label is required',   
            'content.required' => 'Content is required',   
            'seotitle.required' => 'Seo title is required',   
            'seokeyword.required' => 'Seo keyword is required',   
            'active.required' => 'Status is required',   
        ];
    }
}
