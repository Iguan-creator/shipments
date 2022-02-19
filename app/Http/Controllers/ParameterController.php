<?php

namespace App\Http\Controllers;

use App\Models\Parameter;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class ParameterController extends Controller
{
    /**
     * Get list of all parameters
     *
     * @return false|string
     */
    public function index() {
        return json_encode(Parameter::orderBy('order')->get());
    }

    /**
     * Get parameter by name
     *
     * @param $name
     * @return false|JsonResponse|string
     */
    public function getParameterByName(string $name)
    {
        if ($name === 'parameter') {
            $response = ['singular_name' => 'Параметр'];
            return json_encode($response);
        }

        $parameter = Parameter::where('table', Str::singular($name))->first();

        if (!$parameter) {
            $parameter = Parameter::where('table', Str::plural($name))->first();
        }

        return jsonResponse($parameter);
    }
}
