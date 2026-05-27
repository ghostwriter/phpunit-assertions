<?php

declare(strict_types=1);

namespace Ghostwriter\PHPUnitAssertions\Constraint\Class;

use PHPUnit\Framework\Constraint\Constraint;

use function class_implements;
use function in_array;
use function is_object;
use function is_string;
use function sprintf;

final class ClassImplementsInterfaceConstraint extends Constraint
{
    public function __construct(
        private string $interface,
    ) {}

    public function toString(): string
    {
        return sprintf("implements interface '%s'", $this->interface);
    }

    protected function matches(mixed $other): bool
    {
        $class = $this->className($other);

        if (null === $class) {
            return false;
        }

        $interfaces = class_implements($class, true);

        if (false === $interfaces) {
            return false;
        }

        return in_array($this->interface, $interfaces, true);
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
