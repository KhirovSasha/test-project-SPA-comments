<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CaptchaFormRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'username' => 'required',
            'captcha' => 'required|captcha',
            'message' => 'required',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $value = $this->input('message');

            $html = $value;
            preg_match_all('#<([a-zA-Z0-9]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
            $openedtags = $result[1];
            preg_match_all('#</([a-zA-Z0-9]+)>#iU', $html, $result);

            $closedtags = $result[1];
            $len_opened = count($openedtags);

            if (count($closedtags) != $len_opened) {
                $openedtags = array_reverse($openedtags);
                for ($i = 0; $i < $len_opened; $i++) {
                    if (!in_array($openedtags[$i], $closedtags)) {
                        $html .= '</' . $openedtags[$i] . '>';
                    } else {
                        unset($closedtags[array_search($openedtags[$i], $closedtags)]);
                    }
                }

                if (count($closedtags) > 0) {
                    $validator->errors()->add('message', 'Tags are not closed properly.');
                }
            }
        });
    }
}
