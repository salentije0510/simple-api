<?php

declare(strict_types=1);

namespace Frontify\ColorApi;

use Exception;

class DotEnvLoader
{
    private string $path;

    /**
     * @throws Exception
     */
    public function __construct(string $path)
    {
        if (!file_exists($path)) {
            throw new Exception(sprintf('File = %s does not exist', $path));
        }

        $this->path = $path;
    }

    /**
     * @throws Exception
     */
    public function load(): void
    {
        if (!is_readable($this->path)) {
            throw new Exception(sprintf('%s file is not readable', $this->path));
        }

        $lines = file($this->path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
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
