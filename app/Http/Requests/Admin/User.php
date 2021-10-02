<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class User extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    public function all($keys = null)
    {
        return $this->validateFields(parent::all());
    }

    public function validateFields(array $inputs)
    {
        $inputs['cpf'] = str_replace(['.', '-'], '', $this->request->all()['cpf']);
        return $inputs;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //'Type' => 'required|array',
            'name' => 'required|min:3|max:191',
            'nasc' => 'required|date_format:d/m/Y',
            'genero' => 'required|in:masculino,feminino',
            'estado_civil' => 'required|in:casado,separado,solteiro,divorciado,viuvo',
            'cpf' => (!empty($this->request->all()['id']) ? 'required|min:11|max:14|unique:users,cpf,' . $this->request->all()['id'] : 'required|min:11|max:14|unique:users,cpf'),
            //'rg' => 'required_if:client,on|min:8|max:12',
            //'rg' => 'required|min:8|max:12',
            //'rg_expedicao' => 'required',
            //'naturalidade' => 'required_if:client,on',
            //'avatar' => 'image',
            
            // Income
            //'profissao' => 'required_if:client,on',
            //'renda' => 'required_if:client,on',
            //'profissao_empresa' => 'required_if:client,on',
            
            // Address
            // 'cep' => 'required|min:8|max:9',
            // 'rua' => 'required',
            // 'num' => 'required',
            // 'bairro' => 'required',
            // 'uf' => 'required',
            // 'cidade' => 'required',
            
            // Access
            'email' => (!empty($this->request->all()['id']) ? 'required|email|unique:users,email,' . $this->request->all()['id'] : 'required|email|unique:users,email'),
            'password' => (empty($this->request->all()['id']) ? 'required' : ''),
            
            // Contact
            'celular' => 'required',
                        
            // Spouse
//            'tipo_de_comunhao' => 'required_if:estado_civil,casado,separado|in:universal,parcial,total,final',
//            'nome_conjuje' => 'required_if:estado_civil,casado,separado|min:3|max:191',
//            'genero_conjuje' => 'required_if:estado_civil,casado,separado|in:masculino,feminino',
//            'cpf_conjuje' => 'required_if:estado_civil,casado,separado|min:11|max:14',
//            'rg_conjuje' => 'required_if:estado_civil,casado,separado|min:8|max:12',
//            'rg_expedicao_conjuje' => 'required_if:estado_civil,casado,separado',
//            'nasc_conjuje' => 'required_if:estado_civil,casado,separado|date_format:d/m/Y',
//            'naturalidade_conjuje' => 'required_if:estado_civil,casado,separado',
//            'profissao_conjuje' => 'required_if:estado_civil,casado,separado',
//            'renda_conjuje' => 'required_if:estado_civil,casado,separado',
//            'profissao_empresa_conjuje' => 'required_if:estado_civil,casado,separado'
        ];
    }
}
