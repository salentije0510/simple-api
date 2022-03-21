<?php

declare(strict_types=1);

namespace Frontify\ColorApi;

use Exception;

class DotEnvLoader
{
    private const ENV_FILE = '.env';

    /**
     * @throws Exception
     */
    public static function load(): void
    {
        $envFilePath = sprintf('%s%s', Application::PROJECT_ROOT_PATH, self::ENV_FILE);

        if (!is_readable($envFilePath)) {
            throw new Exception(sprintf('File %s is not readable', $envFilePath));
        }

        $lines = file($envFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            if (str_starts_with(trim($line), '#')) {
                continue;
            }

            [$name, $value] = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);

            if (\array_key_exists($name, $_ENV)) {
                continue;
            }

            putenv(sprintf('%s=%s', $name, $value));
            $_ENV[$name] = $value;
        }
    }
}
