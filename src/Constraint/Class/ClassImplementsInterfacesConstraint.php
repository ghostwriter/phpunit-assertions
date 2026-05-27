<?php

declare(strict_types=1);

namespace Ghostwriter\PHPUnitAssertions\Constraint\Class;

use PHPUnit\Framework\Constraint\Constraint;

use function class_implements;
use function implode;
use function in_array;
use function is_object;
use function is_string;
use function sprintf;

final class ClassImplementsInterfacesConstraint extends Constraint
{
    /** @param list<string> $interfaces */
    public function __construct(
        private array $interfaces,
    ) {}

    public function toString(): string
    {
        return sprintf('implements interfaces [%s]', implode(', ', $this->interfaces));
    }

    protected function matches(mixed $other): bool
    {
        $class = $this->className($other);

        if (null === $class) {
            return false;
        }

        $implements = class_implements($class, true);

        if (false === $implements) {
            return false;
        }

        foreach ($this->interfaces as $interface) {
            if (! in_array($interface, $implements, true)) {
                return false;
            }
        }

        return true;
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
