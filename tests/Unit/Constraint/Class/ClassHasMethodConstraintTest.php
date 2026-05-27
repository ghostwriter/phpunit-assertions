<?php

declare(strict_types=1);

namespace Tests\Unit\Constraint\Class;

use Countable;
use Ghostwriter\PHPUnitAssertions\Constraint\Class\ClassExtendsClassConstraint;
use Ghostwriter\PHPUnitAssertions\Constraint\Class\ClassHasMethodConstraint;
use Ghostwriter\PHPUnitAssertions\Constraint\Class\ClassImplementsInterfaceConstraint;
use Ghostwriter\PHPUnitAssertions\Trait\ClassAssertionsTrait;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\UsesTrait;
use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\SelfDescribing;
use Tests\Fixture\Class\ClassHasMethodWithInvoke;
use Tests\Fixture\Class\ClassHasMethodWithoutInvoke;
use Tests\Unit\AbstractTestCase;

#[CoversClass(ClassHasMethodConstraint::class)]
#[UsesClass(ClassExtendsClassConstraint::class)]
#[UsesClass(ClassImplementsInterfaceConstraint::class)]
#[UsesTrait(ClassAssertionsTrait::class)]
final class ClassHasMethodConstraintTest extends AbstractTestCase
{
    use ClassAssertionsTrait;

    public function testCustomFailureMessage(): void
    {
        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('custom has-method message');

        self::assertThat(
            ClassHasMethodWithoutInvoke::class,
            new ClassHasMethodConstraint('invoke'),
            'custom has-method message',
        );
    }

    public function testDefaultFailureMessage(): void
    {
        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage("has method 'invoke'");

        self::assertThat(ClassHasMethodWithoutInvoke::class, new ClassHasMethodConstraint('invoke'));
    }

    public function testExtendsConstraint(): void
    {
        self::assertClassExtendsClass(ClassHasMethodConstraint::class, Constraint::class);
    }

    public function testImplementsCountable(): void
    {
        self::assertClassImplementsInterface(ClassHasMethodConstraint::class, Countable::class);
    }

    public function testImplementsSelfDescribing(): void
    {
        self::assertClassImplementsInterface(ClassHasMethodConstraint::class, SelfDescribing::class);
    }

    public function testMatchesClassStringAndObject(): void
    {
        $constraint = new ClassHasMethodConstraint('invoke');

        self::assertTrue($constraint->evaluate(ClassHasMethodWithInvoke::class, '', true));
        self::assertFalse($constraint->evaluate(ClassHasMethodWithoutInvoke::class, '', true));
        self::assertTrue($constraint->evaluate(new ClassHasMethodWithInvoke(), '', true));
    }

    public function testMatchesObjectInput(): void
    {
        $constraint = new ClassHasMethodConstraint('invoke');

        self::assertTrue($constraint->evaluate(new ClassHasMethodWithInvoke(), '', true));
    }

    public function testReturnsFalseWhenInputIsNotClassStringOrObject(): void
    {
        $constraint = new ClassHasMethodConstraint('invoke');

        self::assertFalse($constraint->evaluate(123, '', true));
    }
}
