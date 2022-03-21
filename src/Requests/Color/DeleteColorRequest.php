<?php

declare(strict_types=1);

namespace Frontify\ColorApi\Requests\Color;

use Frontify\ColorApi\Requests\BaseRequest;

class DeleteColorRequest extends BaseRequest
{
    protected static array $required = ['id'];

    private int $id;

    public function __construct(array $parameters)
    {
        parent::__construct(['id']);
        $this->validate($parameters);

        $this->id = (int) $parameters['id'];
    }

    public function getId(): int
    {
        return $this->id;
    }
}
