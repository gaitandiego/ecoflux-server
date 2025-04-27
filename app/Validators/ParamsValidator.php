<?php

namespace App\Validators;

use App\Exceptions\InvalidParametersException;

class ParamsValidator
{
    //valida los parametros  y que cumplan con lo espeficado
    public function validate($params)
    {
        $errors = [];
        foreach ($params as $param => $data) {
            if ($data['value'] === null) {
                $errors[$param] = 'Should not be empty';
            } elseif ($data['value'] !== '') {
                $validate = '';
                switch ($data['type']) {
                    case 'offset':
                        $validate = $this->validateOffset($data['value']);
                        break;
                    case 'length':
                        $validate = $this->validateLength($data['value']);
                        break;
                    case 'date':
                        $validate = $this->validateDate($data['value']);
                        break;
                    case 'boolean':
                        $validate = $this->validateBoolean($data['value']);
                        break;
                    case 'json':
                        $validate = $this->validateJson($data['value']);
                        break;
                    case 'string':
                        $validate = $this->validateString($data['value']);
                        break;
                    case 'integer':
                        $validate = $this->validateInteger($data['value']);
                        break;
                    case 'integersString':
                        $validate = $this->validateIntegersByComma($data['value']);
                        break;
                    case 'stringsByCommas':
                        $validate = $this->validateStringsByComma($data['value']);
                        break;
                    case 'array':
                        $validate = $this->validateArray($data['value']);
                        break;
                    case 'stringAndInteger':
                        $validate = $this->validateStringAndInteger($data['value']);
                        break;
                    default:
                        // only should appear when the developer make a mistake in the type
                        $validate = [
                            'valid' => false,
                            'message' => 'Invalid param type'
                        ];
                        break;
                }
                if (!$validate['valid']) {
                    $errors[$param] = $validate['message'];
                }
            }
        }
        if (!empty($errors)) {
            throw new InvalidParametersException('Invalid parameters', 422, $errors);
        }
    }

    protected function validateJson($json)
    {
        $ob = @json_decode($json);
        if (json_last_error() === JSON_ERROR_NONE && strpos($json, '{') !== false) {
            return ['valid' => true];
        } else {
            return [
                'valid' => false,
                'message' => 'Should be a valid JSON'
            ];
        }
    }

    protected function validateString($string)
    {
        if (is_string($string) && !is_numeric($string)) {
            return ['valid' => true];
        } else {
            return [
                'valid' => false,
                'message' => 'Should be a string'
            ];
        }
    }

    protected function validateStringAndInteger($string)
    {
        if (is_string($string) || is_numeric($string)) {
            return ['valid' => true];
        } else {
            return [
                'valid' => false,
                'message' => 'Should be a string'
            ];
        }
    }

    protected function validateInteger($integer)
    {
        if (is_numeric($integer)) {
            return ['valid' => true];
        } else {
            return [
                'valid' => false,
                'message' => 'Should be an integer'
            ];
        }
    }

    protected function validateOffset($offset)
    {
        if ((filter_var($offset, FILTER_VALIDATE_INT) === 0 || filter_var($offset, FILTER_VALIDATE_INT)) && $offset >= 0) {
            return ['valid' => true];
        } else {
            return [
                'valid' => false,
                'message' => 'Offset should be integer and positive'
            ];
        }
    }

    protected function validateLength($length)
    {
        if (filter_var($length, FILTER_VALIDATE_INT, array("options" => array("min_range" => 1, "max_range" => 1000))) !== false) {
            return ['valid' => true];
        } else {
            return [
                'valid' => false,
                'message' => 'Lenght should be integer between 1 and 1000'
            ];
        }
    }

    protected function validateDate($date)
    {
        $validFormat = 'Y-m-d H:i:s';
        $dateTime = \DateTime::createFromFormat($validFormat, $date);
        if ($dateTime && $dateTime->format($validFormat) === $date) {
            return ['valid' => true];
        } else {
            return [
                'valid' => false,
                'message' => 'Invalid date format. Expected format example: 2019-01-23 04:34:39',
            ];
        }
    }

    protected function validateIntegersByComma($string)
    {
        $array = explode(',', $string);
        $allNumbers = true;
        foreach ($array as $key => $int) {
            if (!is_numeric($int)) {
                $allNumbers = false;
            }
        }
        if ($allNumbers) {
            return ['valid' => true];
        } else {
            return [
                'valid' => false,
                'message' => 'Should be a string with integers separated by commas'
            ];
        }
    }

    protected function validateBoolean($boolean)
    {
        if (
            $boolean === 1 || $boolean === '1' || $boolean === 'true' || $boolean === true
            || $boolean === 0 || $boolean === '0' || $boolean === 'false' || $boolean === false
        ) {
            return ['valid' => true];
        } else {
            return [
                'valid' => false,
                'message' => 'Should be a boolean'
            ];
        }
    }

    protected function validateStringsByComma($string)
    {
        $array = explode(',', $string);
        $allStrings = true;
        foreach ($array as $str) {
            if (!is_string($str)) {
                $allStrings = false;
            }
        }
        if ($allStrings) {
            return ['valid' => true];
        } else {
            return [
                'valid' => false,
                'message' => 'Should be a string with strings separated by commas'
            ];
        }
    }

    protected function validateArray($array)
    {
        if (is_array($array)) {
            return ['valid' => true];
        } else {
            return [
                'valid' => false,
                'message' => 'Should be an array'
            ];
        }
    }
}
