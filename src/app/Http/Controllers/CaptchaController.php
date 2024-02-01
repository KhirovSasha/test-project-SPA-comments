<?php

namespace App\Http\Controllers;

use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CaptchaController extends Controller
{
    public function capthcaFormValidate(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'username' => 'required',
            'captcha' => 'required|captcha',
            'message' => [
                'required',
                function ($attribute, $value, $fail) {
                    // Ваш код для перевірки закриття тегів
                    $html = $value;
                    preg_match_all('#<([a-zA-Z0-9]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
                    $openedtags = $result[1];
                    preg_match_all('#</([a-zA-Z0-9]+)>#iU', $html, $result);
                    
                    $closedtags = $result[1];
                    $len_opened = count($openedtags);
                    
                    if (count($closedtags) == $len_opened) {
                        return true;
                    }
        
                    $openedtags = array_reverse($openedtags);
                    for ($i=0; $i < $len_opened; $i++) {
                        if (!in_array($openedtags[$i], $closedtags)) {
                            $html .= '</'.$openedtags[$i].'>';
                        } else {
                            unset($closedtags[array_search($openedtags[$i], $closedtags)]);
                        }
                    }
        
                    if (count($closedtags) > 0) {
                        $fail("Tags are not closed properly.");
                    }
                    
                    return true;
                },
            ],
        ]);

        //Debugbar::info($validator);

        if ($validator->fails()) {
            $errors = $validator->errors();
    
            $emailError = $errors->first('email');
            $usernameError = $errors->first('username');
            $captchaError = $errors->first('captcha');
            $messageError = $errors->first('message');
    
            $response = [
                'errors' => [
                    'email' => $emailError,
                    'username' => $usernameError,
                    'captcha' => $captchaError,
                    'message' =>  $messageError,
                ],
            ];
    
            return response()->json($response, 422);
        }
    
        return response()->json(['message' => 'Form submitted successfully']);
    }

    public function reloadCaptcha()
    {
        return response()->json(['captcha'=> captcha_src()]);
    }
}
