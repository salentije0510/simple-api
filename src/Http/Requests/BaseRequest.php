<?php

declare(strict_types=1);

namespace Frontify\ColorApi\Http\Requests;

class BaseRequest
{
    private array $required;

    public function __construct(array $requiredFields = [])
    {
        $this->required = $requiredFields;
    }

    /**
     * @throws \Exception
     */
    protected function validate(array $parameters): void
    {
        // In order to save time values have not been validated
        foreach ($this->required as $requiredParam) {
            if (!\array_key_exists($requiredParam, $parameters)) {
                throw new \Exception(
                    sprintf('Required param missing from the request body: %s', $requiredParam)
                );
            }
        }
    }
}
