<?php

declare(strict_types=1);

namespace Tests\Unit\Constraint\Class;

use Countable;
use Ghostwriter\PHPUnitAssertions\Constraint\Class\ClassExtendsClassConstraint;
use Ghostwriter\PHPUnitAssertions\Constraint\Class\ClassExtendsClassesConstraint;
use Ghostwriter\PHPUnitAssertions\Constraint\Class\ClassImplementsInterfaceConstraint;
use Ghostwriter\PHPUnitAssertions\Trait\ClassAssertionsTrait;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\UsesTrait;
use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\SelfDescribing;
use Tests\Fixture\Class\ClassExtendsClassesBase;
use Tests\Fixture\Class\ClassExtendsClassesLeaf;
use Tests\Fixture\Class\ClassExtendsClassesPeer;
use Tests\Fixture\Class\ClassExtendsClassesRoot;
use Tests\Unit\AbstractTestCase;

use function sprintf;

#[CoversClass(ClassExtendsClassesConstraint::class)]
#[UsesClass(ClassExtendsClassConstraint::class)]
#[UsesClass(ClassImplementsInterfaceConstraint::class)]
#[UsesTrait(ClassAssertionsTrait::class)]
final class ClassExtendsClassesConstraintTest extends AbstractTestCase
{
    use ClassAssertionsTrait;

    public function testCustomFailureMessage(): void
    {
        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('custom extends-classes message');

        self::assertThat(
            ClassExtendsClassesPeer::class,
            new ClassExtendsClassesConstraint([ClassExtendsClassesBase::class, ClassExtendsClassesRoot::class]),
            'custom extends-classes message',
        );
    }

    public function testDefaultFailureMessage(): void
    {
        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage(sprintf(
            'extends classes [%s, %s]',
            ClassExtendsClassesBase::class,
            ClassExtendsClassesRoot::class,
        ));

        self::assertThat(
            ClassExtendsClassesPeer::class,
            new ClassExtendsClassesConstraint([ClassExtendsClassesBase::class, ClassExtendsClassesRoot::class]),
        );
    }

    public function testExtendsConstraint(): void
    {
        self::assertClassExtendsClass(ClassExtendsClassesConstraint::class, Constraint::class);
    }

    public function testImplementsCountable(): void
    {
        self::assertClassImplementsInterface(ClassExtendsClassesConstraint::class, Countable::class);
    }

    public function testImplementsSelfDescribing(): void
    {
        self::assertClassImplementsInterface(ClassExtendsClassesConstraint::class, SelfDescribing::class);
    }

    public function testMatchesAllParentClasses(): void
    {
        $constraint = new ClassExtendsClassesConstraint([
            ClassExtendsClassesBase::class,
            ClassExtendsClassesRoot::class,
        ]);

        self::assertTrue($constraint->evaluate(ClassExtendsClassesLeaf::class, '', true));
        self::assertFalse($constraint->evaluate(ClassExtendsClassesPeer::class, '', true));
    }

    public function testMatchesObjectInput(): void
    {
        $constraint = new ClassExtendsClassesConstraint([
            ClassExtendsClassesBase::class,
            ClassExtendsClassesRoot::class,
        ]);

        self::assertTrue($constraint->evaluate(new ClassExtendsClassesLeaf(), '', true));
    }

    public function testReturnsFalseWhenInputIsNotClassStringOrObject(): void
    {
        $constraint = new ClassExtendsClassesConstraint([
            ClassExtendsClassesBase::class,
            ClassExtendsClassesRoot::class,
        ]);

        self::assertFalse($constraint->evaluate(123, '', true));
    }
}
