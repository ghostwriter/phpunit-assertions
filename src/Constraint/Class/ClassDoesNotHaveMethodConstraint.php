<?php

declare(strict_types=1);

namespace Ghostwriter\PHPUnitAssertions\Constraint\Class;

use PHPUnit\Framework\Constraint\Constraint;

use function is_object;
use function is_string;
use function method_exists;
use function sprintf;

final class ClassDoesNotHaveMethodConstraint extends Constraint
{
    public function __construct(
        private string $methodName,
    ) {}

    public function toString(): string
    {
        return sprintf("does not have method '%s'", $this->methodName);
    }

    protected function matches(mixed $other): bool
    {
        $class = $this->className($other);

        if (null === $class) {
            return false;
        }

        return ! method_exists($class, $this->methodName);
    }

    private function className(mixed $class): ?string
    {
        if (is_string($class)) {
            return $class;
        }

        if (is_object($class)) {
            return $class::class;
        }

        return null;
    }
}
