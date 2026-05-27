<?php

declare(strict_types=1);

namespace Tests\Unit\Constraint\Class;

use Countable;
use Ghostwriter\PHPUnitAssertions\Constraint\Class\ClassDoesNotHaveMethodConstraint;
use Ghostwriter\PHPUnitAssertions\Constraint\Class\ClassExtendsClassConstraint;
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

#[CoversClass(ClassDoesNotHaveMethodConstraint::class)]
#[UsesClass(ClassExtendsClassConstraint::class)]
#[UsesClass(ClassImplementsInterfaceConstraint::class)]
#[UsesTrait(ClassAssertionsTrait::class)]
final class ClassDoesNotHaveMethodConstraintTest extends AbstractTestCase
{
    use ClassAssertionsTrait;

    public function testCustomFailureMessage(): void
    {
        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('custom does-not-have-method message');

        self::assertThat(
            ClassHasMethodWithInvoke::class,
            new ClassDoesNotHaveMethodConstraint('invoke'),
            'custom does-not-have-method message',
        );
    }

    public function testDefaultFailureMessage(): void
    {
        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage("does not have method 'invoke'");

        self::assertThat(ClassHasMethodWithInvoke::class, new ClassDoesNotHaveMethodConstraint('invoke'));
    }

    public function testExtendsConstraint(): void
    {
        self::assertClassExtendsClass(ClassDoesNotHaveMethodConstraint::class, Constraint::class);
    }

    public function testImplementsCountable(): void
    {
        self::assertClassImplementsInterface(ClassDoesNotHaveMethodConstraint::class, Countable::class);
    }

    public function testImplementsSelfDescribing(): void
    {
        self::assertClassImplementsInterface(ClassDoesNotHaveMethodConstraint::class, SelfDescribing::class);
    }

    public function testMatchesClassStringAndObject(): void
    {
        $constraint = new ClassDoesNotHaveMethodConstraint('invoke');

        self::assertTrue($constraint->evaluate(ClassHasMethodWithoutInvoke::class, '', true));
        self::assertFalse($constraint->evaluate(ClassHasMethodWithInvoke::class, '', true));
        self::assertTrue($constraint->evaluate(new ClassHasMethodWithoutInvoke(), '', true));
    }

    public function testMatchesObjectInput(): void
    {
        $constraint = new ClassDoesNotHaveMethodConstraint('invoke');

        self::assertTrue($constraint->evaluate(new ClassHasMethodWithoutInvoke(), '', true));
    }

    public function testReturnsFalseWhenInputIsNotClassStringOrObject(): void
    {
        $constraint = new ClassDoesNotHaveMethodConstraint('invoke');

        self::assertFalse($constraint->evaluate(123, '', true));
    }
}
