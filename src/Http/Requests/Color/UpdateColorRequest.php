<?php

declare(strict_types=1);

namespace Frontify\ColorApi\Http\Requests\Color;

use Frontify\ColorApi\Http\Requests\BaseRequest;

class UpdateColorRequest extends BaseRequest
{
    private int $id;

    private string $name;

    private string $hex;

    public function __construct(array $parameters)
    {
        parent::__construct(['id', 'name', 'hex']);
        $this->validate($parameters);

        $this->id = (int)$parameters['id'];
        $this->name = $parameters['name'];
        $this->hex = $parameters['hex'];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getHex(): string
    {
        return $this->hex;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'hex' => $this->hex
        ];
    }
}
