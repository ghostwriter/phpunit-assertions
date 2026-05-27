<?php

declare(strict_types=1);

namespace Ghostwriter\PHPUnitAssertions\Constraint\Class;

use PHPUnit\Framework\Constraint\Constraint;

use function implode;
use function is_object;
use function is_string;
use function is_subclass_of;
use function sprintf;

final class ClassExtendsClassesConstraint extends Constraint
{
    /** @param list<string> $parentClasses */
    public function __construct(
        private array $parentClasses,
    ) {}

    public function toString(): string
    {
        return sprintf('extends classes [%s]', implode(', ', $this->parentClasses));
    }

    protected function matches(mixed $other): bool
    {
        $class = $this->className($other);

        if (null === $class) {
            return false;
        }

        foreach ($this->parentClasses as $parentClass) {
            if (! is_subclass_of($class, $parentClass, true)) {
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
