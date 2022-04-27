<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TarefaRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tarefa' => 'required|string|max:200',
            'data_limite_conclusao' => 'required|date'
        ];
    }
}
