<?php

declare(strict_types=1);

namespace Frontify\ColorApi\Http\Requests\Color;

use Frontify\ColorApi\Http\Requests\BaseRequest;

class GetColorRequest extends BaseRequest
{
    private int $id;

    /**
     * @throws \Exception
     */
    public function __construct(array $params)
    {
        parent::__construct(['id']);

        $this->validate($params);
        $this->id = (int) $params['id'];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
        ];
    }
}
