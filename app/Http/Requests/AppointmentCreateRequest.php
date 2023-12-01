<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class AppointmentCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'patient_name' => ['required', 'string', 'max:255'],
            'patient_phone_number' => ['required', 'string', 'max:255'],
            'patient_address' => ['required', 'string', 'max:255'],
            'appointment_date' => ['required'],
            'type_appointment' => ['required', 'in:BPJS,Umum,Mandiri,Asuransi'],
            'doctor_id' => ['required']
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response([
            "errors" => $validator->getMessageBag()
        ], 400));
    }
}
