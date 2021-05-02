<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Captcha implements Rule
{
    private $ipAddress;
    private $errors;


    public function __construct($ipAddress=null)
    {
        $this->ipAddress = $ipAddress;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $response = Http::asForm()->post(config('captcha.verifyurl'), [
            'secret' => config('captcha.secret'),
            'response' => $value,
            'remoteip' => $this->ipAddress,
        ]);

        $this->errors = data_get($response->json(), 'error-codes', []);

        return !!data_get($response->json(), 'success', false);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if (empty($this->errors))
            return 'Captcha error!';
        return 'Captcha error: '.implode(', ', $this->errors);
    }
}
