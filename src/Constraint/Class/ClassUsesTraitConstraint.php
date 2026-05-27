<?php

declare(strict_types=1);

namespace Ghostwriter\PHPUnitAssertions\Constraint\Class;

use PHPUnit\Framework\Constraint\Constraint;

use function class_uses;
use function get_parent_class;
use function in_array;
use function is_object;
use function is_string;
use function sprintf;

final class ClassUsesTraitConstraint extends Constraint
{
    public function __construct(
        private string $trait,
    ) {}

    public function toString(): string
    {
        return sprintf("uses trait '%s'", $this->trait);
    }

    protected function matches(mixed $other): bool
    {
        $class = $this->className($other);

        if (null === $class) {
            return false;
        }

        do {
            $uses = class_uses($class);

            if (false === $uses) {
                break;
            }

            if (in_array($this->trait, $uses, true)) {
                return true;
            }
        } while ($class = get_parent_class($class));

        return false;
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
