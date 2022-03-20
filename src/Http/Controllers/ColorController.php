<?php

declare(strict_types=1);

namespace Frontify\ColorApi\Http\Controllers;

use Exception;
use Frontify\ColorApi\Entity\ColorEntity;
use Frontify\ColorApi\Http\Requests\Color\DeleteColorRequest;
use Frontify\ColorApi\Http\Requests\Color\GetColorRequest;
use Frontify\ColorApi\Http\Requests\Color\GetColorsRequest;
use Frontify\ColorApi\Http\Requests\Color\SaveColorRequest;
use Frontify\ColorApi\Http\Requests\Color\UpdateColorRequest;
use Frontify\ColorApi\Repository\ColorRepository;

class ColorController
{
    public function __construct(private ColorRepository $colorRepository)
    {
    }

    public function index(GetColorsRequest $request): array
    {
        try {
            $colorEntities = $request->hasFilters()
                ? $this->colorRepository->findBy($request->getFilters())
                : $this->colorRepository->findAll();
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Something went wrong while searching for the color.'];
        }

        $colors = array_map(static fn(ColorEntity $entity) => $entity->toAssocArray(), $colorEntities);

        return !empty($colors)
            ? ['success' => true, 'data' => $colors]
            : ['success' => false, 'message' => 'Unable to fetch colors'];
    }

    public function view(GetColorRequest $request): array
    {
        try {
            $colorEntity = $this->colorRepository->find($request->getId());
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Something went wrong while searching for the color.'];
        }

        return $colorEntity
            ? ['success' => true, 'data' => $colorEntity->toAssocArray()]
            : ['success' => false, 'message' => sprintf('Unable to find color with id = %s', $request->getId())];
    }

    public function save(SaveColorRequest $request): array
    {
        $colorEntity = new ColorEntity(name: $request->getName(), hex: $request->getHex());

        try {
            $savedEntity = $this->colorRepository->save($colorEntity);
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Something went wrong while saving the color.'];
        }

        return ['success' => true, 'data' => $savedEntity->toAssocArray()];
    }

    public function update(UpdateColorRequest $request): array
    {
        try {
            $colorExist = (bool) $this->colorRepository->find($request->getId());
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Something went wrong while updating the color.'];
        }

        if (!$colorExist) {
            return ['success' => false, 'message' => 'Unable to update color since color does not exist.'];
        }

        $colorEntity = new ColorEntity($request->getName(), $request->getHex(), $request->getId());

        try {
            $this->colorRepository->update($colorEntity);
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Something went wrong while updating the color.'];
        }

        return ['success' => true, 'data' => $colorEntity->toAssocArray()];
    }

    public function delete(DeleteColorRequest $request): array
    {
        try {
            $this->colorRepository->delete($request->getId());
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Something went wrong while deleting the color.'];
        }

        return ['success' => true];
    }
}
