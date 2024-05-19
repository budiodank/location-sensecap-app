<?php

namespace App\Http\Requests\Master;

use App\Traits\MainTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class DeviceRequest extends FormRequest
{
    use MainTrait;
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
        if (request()->routeIs('device.insert')) {
            $device = Rule::unique('tbl_device', 'node_eui');
        }

        if (request()->routeIs('device.update')) {
            $device =
                Rule::unique('tbl_device', 'node_eui')
                ->ignore($this->device_uuid, 'device_uuid');
        }

        return [
            'node_eui'      => ['required', $device],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = $this->sendError($validator->errors(), 422);
        throw new HttpResponseException($response);
    }
}
