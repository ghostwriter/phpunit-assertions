<?php

declare(strict_types=1);

namespace Tests\Unit\Constraint\Class;

use Countable;
use Ghostwriter\PHPUnitAssertions\Constraint\Class\ClassExtendsClassConstraint;
use Ghostwriter\PHPUnitAssertions\Constraint\Class\ClassImplementsInterfaceConstraint;
use Ghostwriter\PHPUnitAssertions\Trait\ClassAssertionsTrait;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\UsesTrait;
use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\SelfDescribing;
use Tests\Fixture\Class\ClassImplementsInterfaceImplementation;
use Tests\Fixture\Class\ClassImplementsInterfacePeer;
use Tests\Fixture\Interface\ClassImplementsInterfaceContract;
use Tests\Unit\AbstractTestCase;

use function sprintf;

#[CoversClass(ClassImplementsInterfaceConstraint::class)]
#[UsesClass(ClassExtendsClassConstraint::class)]
#[UsesTrait(ClassAssertionsTrait::class)]
final class ClassImplementsInterfaceConstraintTest extends AbstractTestCase
{
    use ClassAssertionsTrait;

    public function testCustomFailureMessage(): void
    {
        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('custom implements-interface message');

        self::assertThat(
            ClassImplementsInterfacePeer::class,
            new ClassImplementsInterfaceConstraint(ClassImplementsInterfaceContract::class),
            'custom implements-interface message',
        );
    }

    public function testDefaultFailureMessage(): void
    {
        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage(sprintf("implements interface '%s'", ClassImplementsInterfaceContract::class));

        self::assertThat(
            ClassImplementsInterfacePeer::class,
            new ClassImplementsInterfaceConstraint(ClassImplementsInterfaceContract::class),
        );
    }

    public function testExtendsConstraint(): void
    {
        self::assertClassExtendsClass(ClassImplementsInterfaceConstraint::class, Constraint::class);
    }

    public function testImplementsCountable(): void
    {
        self::assertClassImplementsInterface(ClassImplementsInterfaceConstraint::class, Countable::class);
    }

    public function testImplementsSelfDescribing(): void
    {
        self::assertClassImplementsInterface(ClassImplementsInterfaceConstraint::class, SelfDescribing::class);
    }

    public function testMatchesInterfaceAndInheritedInterface(): void
    {
        $constraint = new ClassImplementsInterfaceConstraint(ClassImplementsInterfaceContract::class);

        self::assertTrue($constraint->evaluate(ClassImplementsInterfaceImplementation::class, '', true));
        self::assertFalse($constraint->evaluate(ClassImplementsInterfacePeer::class, '', true));
    }

    public function testMatchesObjectInput(): void
    {
        $constraint = new ClassImplementsInterfaceConstraint(ClassImplementsInterfaceContract::class);

        self::assertTrue($constraint->evaluate(new ClassImplementsInterfaceImplementation(), '', true));
    }

    public function testReturnsFalseWhenClassStringCannotBeReflectedByClassImplements(): void
    {
        $constraint = new ClassImplementsInterfaceConstraint(ClassImplementsInterfaceContract::class);

        self::assertFalse(@$constraint->evaluate('Tests\\Fixture\\Class\\MissingImplementsInterfaceTarget', '', true));
    }

    public function testReturnsFalseWhenInputIsNotClassStringOrObject(): void
    {
        $constraint = new ClassImplementsInterfaceConstraint(ClassImplementsInterfaceContract::class);

        self::assertFalse($constraint->evaluate(123, '', true));
    }
}
