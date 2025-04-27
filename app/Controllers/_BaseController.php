<?php

namespace App\Controllers;

use App\Validators\ParamsValidator;

class _BaseController
{
    protected $paramsValidator;

    public function __construct(ParamsValidator $paramsValidator)
    {
        $this->paramsValidator = $paramsValidator;
    }

    protected function getParam($request, $param, $default = null)
    {
        $postParams = json_decode($request->getBody()->__toString(), true);

        $getParams = $request->getQueryParams();
        $params = array_merge(
            !empty($postParams) ? $postParams : [],
            !empty($getParams) ? $getParams : []
        );

        return isset($params[$param]) ? $params[$param] : $default;
    }

    protected function getParamsAndValidate($request, $keys)
    {
        $params = [];
        $validator = [];

        foreach ($keys as $key => $config) {
            $param = $this->getParam(
                $request,
                $key,
                isset($config['default']) ? $config['default'] : ($config['canBeEmpty'] ? '' : null)
            );

            $validator[$key] = ['value' => $param, 'type' => $config['type']];
            $params[$key] = $param;
        }
        $this->paramsValidator->validate($validator);

        return $params;
    }

    protected function getParamBody($request, $param, $default = null)
    {
        $postParams = $request->getParsedBody();
        $getParams = $request->getQueryParams();

        $params = array_merge(
            !empty($postParams) ? $postParams : [],
            !empty($getParams) ? $getParams : []
        );
        return isset($params[$param]) ? $params[$param] : $default;
    }


    protected function getParamsAndValidateBody($request, $keys)
    {
        $params = [];
        $validator = [];

        foreach ($keys as $key => $config) {
            $param = $this->getParamBody(
                $request,
                $key,
                isset($config['default']) ? $config['default'] : ($config['canBeEmpty'] ? '' : null)
            );

            $validator[$key] = ['value' => $param, 'type' => $config['type']];
            $params[$key] = $param;
        }
        $this->paramsValidator->validate($validator);

        return $params;
    }
}
