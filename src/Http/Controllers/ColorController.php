<?php

declare(strict_types=1);

namespace Frontify\ColorApi\Http\Controllers;

use Frontify\ColorApi\Http\Requests\Color\DeleteColorRequest;
use Frontify\ColorApi\Http\Requests\Color\GetColorRequest;
use Frontify\ColorApi\Http\Requests\Color\GetColorsRequest;
use Frontify\ColorApi\Http\Requests\Color\SaveColorRequest;
use Frontify\ColorApi\Http\Requests\Color\UpdateColorRequest;

class ColorController
{
    public function index(GetColorsRequest $request): array
    {
        return ['index'];
    }

    public function view(GetColorRequest $request): array
    {
        return ['view'];
    }

    public function save(SaveColorRequest $request): array
    {
        return ['save'];
    }

    public function update(UpdateColorRequest $request): array
    {
        return ['update'];
    }

    public function delete(DeleteColorRequest $request): array
    {
        return ['delete'];
    }
}
