<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEventRequest extends FormRequest {

    /**
     * Classe para validar os dados para a criação de um evento.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'date' => 'required|date',
            'hour' => 'required|int',
            'desc' => 'required|'
        ];
    }

    public function messages() {
        return [
            'date.required' => 'Data do agendamento inválida',
            'hour.required' => 'Você deve selecionar o horário do agendamento.',
            'password.required' => 'A descrição não pode estar em branco',
            'password.min' => 'Por favor, conte-nos mais detalhes sobre a reserva.',
            'password.max' => 'A descrição deve conter no máximo 120 caracteres',
        ];
    }

}
