<?php


namespace App\Validators;

use App\Exceptions\CustomValidationException;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

class UserValidation
{

    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    /**
     * @throws CustomValidationException
     */
    final function validate(): array
    {
       $requestBody = $this->getRequestBody();

        $errorMessages = $this->validateCollection(collect($requestBody));

        if (count($errorMessages) > 0) {
            throw new CustomValidationException('Validation failed', 422, null, $errorMessages);
        }



    }


    private function getRequestBody(): array
    {
        return $this->request->all();
    }

    protected function validateCollection(Collection $body): array
    {
        $messages = $this->messages();

        $body->each(function ($value, $key) use (&$messages) {

            if (!isset($value['rules'])) {
                $this->validateRulesKeyExists($value, $key, $messages);
                return;
            }


            $requestRules = explode('|', $value['rules']);

            for ($i = 0; $i < count($requestRules); $i++) {
                $rule = $requestRules[$i];

                if ($rule === 'required') {
                    $this->validateRequired($value, $key, $messages);
                }

                if ($rule === 'alpha') {
                    $this->validateAlpha($value, $key, $messages);
                }

                if ($rule === 'email') {
                    $this->validateEmail($value, $key, $messages);
                }

                if ($rule === 'number') {
                    $this->validateNumber($value, $key, $messages);
                }

            }

        });

        return $messages;

    }



    protected function messages(): array
    {

        return [];
    }

    private function validateRequired($value, $key, &$messages)
    {
        if (empty($value['value'])) {

            $messages[$key][] = 'The ' . $key . ' field is required.';
        }
    }

    private function validateAlpha($value, $key, &$messages)
    {
        if (!ctype_alpha($value['value'])) {
            $messages[$key][] = 'The ' . $key . ' field must be alpha.';
        }
    }

    private function validateEmail($value, $key, &$messages)
    {
        if (!filter_var($value['value'], FILTER_VALIDATE_EMAIL)) {
            $messages[$key][] = 'The ' . $key . ' field must be email.';
        }
    }

    private function validateNumber($value, $key, &$messages)
    {
        if (!is_numeric($value['value'])) {
            $messages[$key][] = 'The ' . $key . ' field must be number.';
        }
    }

    private function validateRulesKeyExists($value, $key, &$messages)
    {
        if (!isset($value['rules'])) {
            $messages[$key][] = 'Rules not given';
        }
    }

}
