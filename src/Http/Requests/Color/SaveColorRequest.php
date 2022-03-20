<?php

declare(strict_types=1);

namespace Frontify\ColorApi\Http\Requests\Color;

use Frontify\ColorApi\Http\Requests\BaseRequest;

class SaveColorRequest extends BaseRequest
{
    private string $name;

    private string $hex;

    /**
     * @throws \Exception
     */
    public function __construct(array $params)
    {
        parent::__construct(['name', 'hex']);
        $this->validate($params);

        $this->name = $params['name'];
        $this->hex = $params['hex'];
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
            'name' => $this->name,
            'hex' => $this->hex
        ];
    }
}
