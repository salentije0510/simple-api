<?php

declare(strict_types=1);

namespace Frontify\ColorApi\Factories;

use Exception;
use Frontify\ColorApi\Controllers\ColorController;
use Frontify\ColorApi\Requests\BaseRequest;
use Frontify\ColorApi\Requests\Color\DeleteColorRequest;
use Frontify\ColorApi\Requests\Color\GetColorRequest;
use Frontify\ColorApi\Requests\Color\GetColorsRequest;
use Frontify\ColorApi\Requests\Color\SaveColorRequest;
use Frontify\ColorApi\Requests\Color\UpdateColorRequest;
use JsonException;
use Psr\Http\Message\ServerRequestInterface;

class RequestFactory
{
    /**
     * @throws Exception
     */
    public static function make(
        string $controllerClass,
        string $methodName,
        array $pathVariables,
        ServerRequestInterface $request,
    ): ?BaseRequest {
        $resolvedRequest = null;

        $requestBody = self::encodeBody($request);

        // In case of multiple controllers we can add additional dedicated controller factory classes and use this one
        // to switch between those classes based on the controller class. For now, we are going simple.
        if ($controllerClass === ColorController::class) {
            $resolvedRequest = match ($methodName) {
                'save' => new SaveColorRequest($requestBody),
                'update' => new UpdateColorRequest(array_merge($pathVariables, $requestBody)),
                'index' => new GetColorsRequest($pathVariables),
                'delete' => new DeleteColorRequest($pathVariables),
                default => new GetColorRequest($pathVariables)
            };
        }

        return $resolvedRequest;
    }

    private static function encodeBody(ServerRequestInterface $request): array
    {
        $rawBody = $request->getBody()?->getContents();

        if (empty($rawBody)) {
            return [];
        }

        $stripedBody = trim(preg_replace('/\s\s+/', '', $rawBody));

        try {
            $requestBody = json_decode($stripedBody, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new Exception('Invalid request body provided.');
        }

        return $requestBody;
    }
}
