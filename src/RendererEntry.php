<?php

declare(strict_types=1);

namespace Conia\Error;

use Throwable;

class RendererEntry
{
    private string|int|null $logLevel = null;

    /**
     * @param class-string<Throwable>[] $exceptions
     */
    public function __construct(
        public readonly array $exceptions,
        public readonly Renderer $renderer
    ) {
    }

    public function matches(Throwable $exception): bool
    {
        foreach ($this->exceptions as $exceptionEntry) {
            if ($exception::class === $exceptionEntry) {
                return true;
            }

            if (is_subclass_of($exception::class, $exceptionEntry)) {
                return true;
            }
        }

        return false;
    }

    public function log(string|int $logLevel): void
    {
        $this->logLevel = $logLevel;
    }

    public function getLogLevel(): string|int|null
    {
        return $this->logLevel;
    }
}
