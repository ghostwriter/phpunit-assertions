<?php

declare(strict_types=1);

namespace Ghostwriter\PHPUnitAssertions\Constraint\Class;

use PHPUnit\Framework\Constraint\Constraint;

use function array_merge;
use function class_uses;
use function get_parent_class;
use function implode;
use function in_array;
use function is_object;
use function is_string;
use function sprintf;

final class ClassUsesTraitsConstraint extends Constraint
{
    /** @param list<string> $traits */
    public function __construct(
        private array $traits,
    ) {}

    public function toString(): string
    {
        return sprintf('uses traits [%s]', implode(', ', $this->traits));
    }

    protected function matches(mixed $other): bool
    {
        $class = $this->className($other);

        if (null === $class) {
            return false;
        }

        $uses = [];

        do {
            $classUses = class_uses($class, true);

            if (false === $classUses) {
                break;
            }

            $uses = array_merge($classUses, $uses);
        } while ($class = get_parent_class($class));

        foreach ($this->traits as $trait) {
            if (! in_array($trait, $uses, true)) {
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
