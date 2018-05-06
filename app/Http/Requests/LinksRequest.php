<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LinksRequest extends FormRequest
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

            'url_short' => 'required|unique:links,url_short',
            'url_org' => 'required|unique:links,url_org'


        ];
    }

    public function messages() {
        return [
//            'email.required'	=> 'email wymagany',
//            'email.email' => 'to musi byc email',
//            'name.required'	=> 'nazwa wymagana',
//            'password.required'	=> 'HASŁO wymagane',
//            'email.unique' => 'Ten email jest już zajęty',
//            'url_short.unique' => 'Zajęte',
//            'url_org.unique' => 'Zajęte'
        ];
    }
}
