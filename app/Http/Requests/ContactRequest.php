<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => __('contact.validation.name_required'),
            'name.max' => __('contact.validation.name_max'),
            'email.required' => __('contact.validation.email_required'),
            'email.email' => __('contact.validation.email_invalid'),
            'email.max' => __('contact.validation.email_max'),
            'subject.required' => __('contact.validation.subject_required'),
            'subject.max' => __('contact.validation.subject_max'),
            'message.required' => __('contact.validation.message_required'),
            'message.max' => __('contact.validation.message_max'),
        ];
    }
}
