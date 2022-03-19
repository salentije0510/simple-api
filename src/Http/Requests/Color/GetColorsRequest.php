<?php

declare(strict_types=1);

namespace Frontify\ColorApi\Http\Requests\Color;

use Frontify\ColorApi\Http\Requests\BaseRequest;

class GetColorsRequest extends BaseRequest
{
    private const FILTER_NAME = 'name';
    private const FILTER_HEX = 'hex';

    private $allowedFilters = [
        self::FILTER_NAME,
        self::FILTER_HEX,
    ];

    /** @var array<string, string> */
    private $filters;

    public function __construct(array $parameters)
    {
        foreach ($parameters as $parameter => $value) {
            if (\array_key_exists($parameter, $this->allowedFilters)) {
                $this->filters[$parameter] = $value;
            }
        }
    }

    public function getFilters(): array
    {
        return $this->filters;
    }

    public function hasFilters(): bool
    {
        return empty($this->filters);
    }

    public function getFilter(string $filter): string
    {
        if (!\in_array($filter, $this->filters)) {
            throw new \Exception(sprintf('Filter = %s not supported', $filter));
        }

        return $this->filters[$filter];
    }

    public function toArray(): array
    {
        $requestArray = [];

        foreach ($this->filters as $filter => $value) {
            $requestArray[$filter] = $value;
        }

        return $requestArray;
    }
}
