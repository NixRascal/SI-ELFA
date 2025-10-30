<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSurveyAnswerRequest extends FormRequest
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
        $kuesioner = $this->route('questionnaire');
        $kuesioner->load('pertanyaan');

        $rules = [];
        foreach ($kuesioner->pertanyaan as $question) {
            $key = "jawaban.{$question->id}";
            $rule = $question->wajib_diisi ? 'required' : 'nullable';

            if ($question->jenis_pertanyaan === 'likert') {
                $rule .= '|in:1,2,3,4,5';
            } else {
                $rule .= '|string';
            }

            $rules[$key] = $rule;
        }

        return $rules;
    }
}
