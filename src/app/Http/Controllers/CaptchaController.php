<?php

namespace App\Http\Controllers;

use App\Http\Requests\CaptchaFormRequest;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CaptchaController extends Controller
{
    public function capthcaFormValidate(CaptchaFormRequest $request)
    {
        
        return response()->json(['message' => 'Form submitted successfully']);
    }

    public function reloadCaptcha()
    {
        return response()->json(['captcha'=> captcha_src()]);
    }
}
