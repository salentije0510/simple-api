<?php

declare(strict_types=1);

namespace Frontify\ColorApi\Http\Requests;

use Exception;
use Frontify\ColorApi\Http\Controllers\ColorController;
use Frontify\ColorApi\Http\Requests\Color\DeleteColorRequest;
use Frontify\ColorApi\Http\Requests\Color\GetColorRequest;
use Frontify\ColorApi\Http\Requests\Color\GetColorsRequest;
use Frontify\ColorApi\Http\Requests\Color\SaveColorRequest;
use Frontify\ColorApi\Http\Requests\Color\UpdateColorRequest;
use JsonException;
use Psr\Http\Message\ServerRequestInterface;

class RequestFactory
{
    public static function make(
        string $controllerClass,
        string $methodName,
        array $pathVariables,
        ServerRequestInterface $request
    ): ?BaseRequest {
        try {
            $requestBody = json_decode(
                $request->getBody()->getContents(),
                true,
                512,
                JSON_THROW_ON_ERROR
            );
        } catch (JsonException $e) {
            throw new Exception('Invalid request body provided.');
        }

        $request = null;

        // In case of multiple controllers we can add additional dedicated controller factory classes and use this one
        // to switch between those classes based on the controller class. For now, we are going simple.
        if ($controllerClass === ColorController::class) {
            if ($methodName === 'save') {
                $request = new SaveColorRequest($requestBody);
            } elseif ($methodName === 'update') {
                $request = new UpdateColorRequest(array_merge($pathVariables, $requestBody));
            } elseif ($methodName === 'view') {
                $request = new GetColorsRequest($pathVariables);
            } elseif ($methodName === 'index') {
                $request = new GetColorRequest($pathVariables);
            } elseif ($methodName === 'delete') {
                $request = new DeleteColorRequest($pathVariables);
            }
        }

        return $request;
    }
}
