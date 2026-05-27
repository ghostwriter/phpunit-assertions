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
use Tests\Fixture\Class\ClassExtendsClassChild;
use Tests\Fixture\Class\ClassExtendsClassParent;
use Tests\Fixture\Class\ClassExtendsClassPeer;
use Tests\Unit\AbstractTestCase;

use function sprintf;

#[CoversClass(ClassExtendsClassConstraint::class)]
#[UsesClass(ClassImplementsInterfaceConstraint::class)]
#[UsesTrait(ClassAssertionsTrait::class)]
final class ClassExtendsClassConstraintTest extends AbstractTestCase
{
    use ClassAssertionsTrait;

    public function testCustomFailureMessage(): void
    {
        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('custom extends-class message');

        self::assertThat(
            ClassExtendsClassPeer::class,
            new ClassExtendsClassConstraint(ClassExtendsClassParent::class),
            'custom extends-class message',
        );
    }

    public function testDefaultFailureMessage(): void
    {
        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage(sprintf("extends class '%s'", ClassExtendsClassParent::class));

        self::assertThat(ClassExtendsClassPeer::class, new ClassExtendsClassConstraint(ClassExtendsClassParent::class));
    }

    public function testExtendsConstraint(): void
    {
        self::assertClassExtendsClass(ClassExtendsClassConstraint::class, Constraint::class);
    }

    public function testImplementsCountable(): void
    {
        self::assertClassImplementsInterface(ClassExtendsClassConstraint::class, Countable::class);
    }

    public function testImplementsSelfDescribing(): void
    {
        self::assertClassImplementsInterface(ClassExtendsClassConstraint::class, SelfDescribing::class);
    }

    public function testMatchesClassString(): void
    {
        $constraint = new ClassExtendsClassConstraint(ClassExtendsClassParent::class);

        self::assertTrue($constraint->evaluate(ClassExtendsClassChild::class, '', true));
        self::assertFalse($constraint->evaluate(ClassExtendsClassPeer::class, '', true));
    }

    public function testMatchesObject(): void
    {
        $constraint = new ClassExtendsClassConstraint(ClassExtendsClassParent::class);

        self::assertTrue($constraint->evaluate(new ClassExtendsClassChild(), '', true));
    }

    public function testMatchesObjectInput(): void
    {
        $constraint = new ClassExtendsClassConstraint(ClassExtendsClassParent::class);

        self::assertTrue($constraint->evaluate(new ClassExtendsClassChild(), '', true));
    }

    public function testReturnsFalseWhenInputIsNotClassStringOrObject(): void
    {
        $constraint = new ClassExtendsClassConstraint(ClassExtendsClassParent::class);

        self::assertFalse($constraint->evaluate(123, '', true));
    }
}
