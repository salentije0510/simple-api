<?php

declare(strict_types=1);

namespace Frontify\ColorApi\Exceptions;

use Throwable;

class RouterException extends \Exception
{
    protected const MESSAGE_IDENTIFIER = 'Routing error:';

    public function __construct(string $message, int $code = 404, ?Throwable $previous = null)
    {
        parent::__construct(
            message: sprintf('%s %s', self::MESSAGE_IDENTIFIER, $message),
            code: $code,
            previous: $previous,
        );
    }
}
