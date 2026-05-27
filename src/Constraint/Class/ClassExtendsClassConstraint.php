<?php

declare(strict_types=1);

namespace Ghostwriter\PHPUnitAssertions\Constraint\Class;

use PHPUnit\Framework\Constraint\Constraint;

use function is_object;
use function is_string;
use function is_subclass_of;
use function sprintf;

final class ClassExtendsClassConstraint extends Constraint
{
    public function __construct(
        private string $parentClass,
    ) {}

    public function toString(): string
    {
        return sprintf("extends class '%s'", $this->parentClass);
    }

    protected function matches(mixed $other): bool
    {
        $class = $this->className($other);

        if (null === $class) {
            return false;
        }

        return is_subclass_of($class, $this->parentClass, true);
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
